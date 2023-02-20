"use strict";
const Generator = require("yeoman-generator");
const yosay = require("yosay");
const path = require("path");
const _ = require("lodash");
const fg = require("fast-glob");

module.exports = class extends Generator {
  prompting() {
    this.log(yosay("Generating a WordPress project."));

    const prompts = [
      {
        type: "input",
        name: "destinationFolder",
        message: "Folder to scaffold the project in",
        default: this.destinationPath()
      },
      {
        type: "input",
        name: "projectName",
        message: "Project name"
      },
      {
        type: "list",
        name: "projectType",
        message: "Project type",
        choices: ["theme", "plugin"],
        default: "theme"
      }
    ];

    return this.prompt(prompts).then(props => {
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
      projectType: this.props.projectType
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
      files.map(file => path.join(this.templatePath(), file)),
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

    await this.addDependencies(["@wordpress/dom-ready"]);
    await this.addDevDependencies([
      "cross-env",
      "@tsconfig/recommended",
      "@wordpress/scripts",
      "sass",
      "typescript"
    ]);
  }

  async install() {
    this.spawnCommandSync("composer", [
      "require",
      "--dev",
      "squizlabs/php_codesniffer",
      "wp-coding-standards/wpcs"
    ]);
    this.spawnCommandSync("composer", [
      "require",
      "crosslink-ch/wp-utilitatem"
    ]);
  }
};
