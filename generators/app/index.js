"use strict";
const Generator = require("yeoman-generator");
const yosay = require("yosay");
const path = require("path");
const _ = require("lodash");
const fg = require("fast-glob");
const getLatestVersion = require("get-latest-version");

module.exports = class extends Generator {
  prompting() {
    this.log(yosay("Generating a WordPress project."));

    const prompts = [
      {
        type: "input",
        name: "destinationFolder",
        message: "Folder to scaffold the project in",
        default: this.destinationPath(),
      },
      {
        type: "input",
        name: "projectName",
        message: "Project name",
      },
      {
        type: "list",
        name: "projectType",
        message: "Project type",
        choices: ["theme", "plugin"],
        default: "theme",
      },
      {
        type: "input",
        name: "localDomain",
        message:
          "Domain name of the local server. Do NOT include the protocol, e.g. http://",
      },
    ];

    return this.prompt(prompts).then((props) => {
      // To access props later use this.props.someAnswer;
      this.props = props;
    });
  }

  default() {
    if (this.destinationPath() !== this.props.destinationFolder) {
      this.destinationRoot(
        path.join(this.destinationPath(), this.props.destinationFolder)
      );
    }
  }

  async writing() {
    const isTheme = this.props.projectType === "theme";
    const templateOptions = {
      kebabName: _.kebabCase(this.props.projectName),
      snakeName: _.snakeCase(this.props.projectName),
      projectName: this.props.projectName,
      capitalizedName:
        this.props.projectName[0].toUpperCase() +
        _.camelCase(this.props.projectName.substring(1)),
      projectType: this.props.projectType,
      localDomain: this.props.localDomain,
      isTheme,
    };
    const pluginText = (() => {
      if (isTheme) {
        return "";
      }

      const tmpl = _.template(`
/**
 * Plugin Name: <%- projectName %>
 * Description: Cross-Link project
 * Requires at least: 6.1
 * Requires PHP: 8.1
 * Version: 1.0.0
 * Author: Cross-Link
 * Text Domain: <%- kebabName %>
 */ `);

      return tmpl(templateOptions);
    })();
    templateOptions.pluginText = pluginText;
    templateOptions.fileConstant =
      this.props.projectType === "theme"
        ? `${templateOptions.capitalizedName.toUpperCase()}_THEME_FILE`
        : `${templateOptions.capitalizedName.toUpperCase()}_PLUGIN_FILE`;
    const files = fg.sync("**/*", { dot: true, cwd: this.templatePath() });
    this.fs.copyTpl(
      files.map((file) => path.join(this.templatePath(), file)),
      this.destinationPath(),
      templateOptions
    );
    if (!isTheme) {
      this.fs.delete(this.destinationPath("style.css"));
      this.fs.copy(
        this.destinationPath("functions.php"),
        this.destinationPath(templateOptions.kebabName + ".php")
      );
      this.fs.delete(this.destinationPath("functions.php"));
    }

    this.fs.move(
      this.destinationPath("gitignore-template"),
      this.destinationPath(".gitignore")
    );

    this.fs.move(
      this.destinationPath("gitattributes-template"),
      this.destinationPath(".gitattributes")
    );

    const dependencies = ["@wordpress/dom-ready"];
    const devDependencies = [
      "cross-env",
      "@tsconfig/recommended",
      "@wordpress/scripts",
      "sass",
      "typescript",
      "concurrently",
      "husky",
      "@ribarich/lint-staged",
    ];

    let dependencyVersions = dependencies.map((dependency) =>
      getLatestVersion(dependency)
    );

    let devDependencyVersions = devDependencies.map((dependency) =>
      getLatestVersion(dependency)
    );

    dependencyVersions = await Promise.all(dependencyVersions);
    devDependencyVersions = await Promise.all(devDependencyVersions);

    let rDependencies = dependencies.map((dep, index) => ({
      [dep]: dependencyVersions[index],
    }));
    let rDevDependencies = devDependencies.map((dep, index) => ({
      [dep]: devDependencyVersions[index],
    }));

    rDependencies = rDependencies.reduce(
      (acc, obj) => ({
        ...acc,
        [Object.keys(obj)[0]]: Object.values(obj)[0],
      }),
      {}
    );

    rDevDependencies = rDevDependencies.reduce(
      (acc, obj) => ({
        ...acc,
        [Object.keys(obj)[0]]: Object.values(obj)[0],
      }),
      {}
    );

    await this.addDependencies(rDependencies);
    await this.addDevDependencies(rDevDependencies);
  }

  async install() {
    console.log("installing");
    this.spawnCommandSync("composer", [
      "require",
      "--dev",
      "squizlabs/php_codesniffer",
      "wp-coding-standards/wpcs",
      "wp-phpunit/wp-phpunit",
      "yoast/phpunit-polyfills",
    ]);
    this.spawnCommandSync("composer", [
      "require",
      "crosslink-ch/wp-utilitatem",
    ]);
    this.spawnCommandSync("git", ["init", "-b", "main"]);
  }
};
