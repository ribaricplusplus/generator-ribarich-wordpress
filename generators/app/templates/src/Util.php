<?php

namespace <%- capitalizedName %>;

class Util {
	/**
	 * Get asset contents as string.
	 *
	 * @param string $name relative path from asssets/ folder.
	 */
	public function get_asset( $name ) {
		$name = ltrim( $name, '/' );
		$path = \get_stylesheet_directory() . '/assets/' . $name;

		if ( ! \file_exists( $path ) ) {
			return '';
		}

		return \file_get_contents( $path );
	}

	public function get_field( $field, $id = null, $default = null ) {
		$field = \get_field( $field, $id );

		if ( $field ) {
			return $field;
		}

		return $default;
	}

	/**
	 * $field_descriptors: array where 0: key, 1: default value.
	 *
	 * @param array $field_descriptors
	 * @param int|string $id ACF id where data is.
	 * @return array Key is field name, value is field value.
	 */
	public function get_fields( $field_descriptors, $id ) {
		$result = array();
		foreach ( $field_descriptors as $field_descriptor ) {
			$value                          = $this->get_field( $field_descriptor[0], $id, $field_descriptor[1] );
			$result[ $field_descriptor[0] ] = $value;
		}

		return $result;
	}

	/**
	 * Determine whether taxonomy $tax is registered for an object $obj_type.
	 * For example $tax can be 'category' and $obj_type can be 'post', then
	 * this function would check whether the 'category' taxonomy is registered
	 * for posts.
	 */
	public function is_tax_registered_for_object_type( $tax, $obj_type ) {
		global $wp_taxonomies;

		if ( empty( $wp_taxonomies[ $tax ] ) || empty( $wp_taxonomies[ $tax ]->object_type ) ) {
			return false;
		}

		return \in_array( $obj_type, $wp_taxonomies[ $tax ]->object_type, true );
	}
}
