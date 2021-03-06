<?php

if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

if ( !class_exists( 'Instructor' ) ) {

    class Instructor extends WP_User {

        var $first_name = '';
        var $last_name = '';
        var $courses_number = 0;

        function __construct( $ID, $name = '' ) {
            if ( $ID != 0 ) {
                parent::__construct( $ID, $name );
            }

            /* Set meta vars */

            $this->first_name = get_user_meta( $ID, 'first_name', true );
            $this->last_name = get_user_meta( $ID, 'last_name', true );
            $this->courses_number = Instructor::get_courses_number( $ID );
        }

        function Instructor( $ID, $name = '' ) {
            $this->__construct( $ID, $name );
        }

		static function get_course_meta_keys( $user_id ) {
			$meta = get_user_meta( $user_id );
			$meta = array_filter( array_keys( $meta ), array( 'Instructor', 'filter_course_meta_array' ) );
			return $meta;
		}

		static function filter_course_meta_array( $var ) {
			if( preg_match( '/^course\_/', $var) ) {
				return $var;
			}
		}

        function get_assigned_courses_ids( $status = 'all' ) {
            $assigned_courses = array();

			$courses = Instructor::get_course_meta_keys( $this->ID );

            foreach ( $courses as $course ) {
                $course_id = str_replace( 'course_', '', $course );
                if ( $status !== 'all' ) {
                    if ( get_post_status( $course_id ) == $status ) {
                        $assigned_courses[] = $course_id;
                    }
                } else {
                    $assigned_courses[] = $course_id;
                }
            }

            return $assigned_courses;
        }

        function unassign_from_course( $course_id = 0 ) {
            delete_user_meta( $this->ID, 'course_' . $course_id );
            delete_user_meta( $this->ID, 'enrolled_course_date_' . $course_id );
            delete_user_meta( $this->ID, 'enrolled_course_class_' . $course_id );
            delete_user_meta( $this->ID, 'enrolled_course_group_' . $course_id );
        }

        function unassign_from_all_courses() {
            $courses = $this->get_assigned_courses_ids();
            foreach ( $courses as $course_id ) {
                $this->unassign_from_course( $course_id );
            }
        }

        //Get number of instructor's assigned courses
        static function get_courses_number( $user_id = false ) {

			if ( ! $user_id ) {
				return 0;
			}

            $courses_count = count( Instructor::get_course_meta_keys( $user_id ) );
            return $courses_count;
        }

        function delete_instructor( $delete_user = true ) {
            /*if ( $delete_user ) {
                wp_delete_user( $this->ID ); //without reassign
            }else{//just delete the meta which says that user is an instructor*/
                delete_user_meta( $this->ID, 'role_ins', 'instructor' );
                $this->unassign_from_all_courses();
                CoursePress::instance()->drop_instructor_capabilities( $this->ID );
            //}
        }

	    public static function instructor_by_hash( $hash ) {
			global $wpdb;

		    $sql = $wpdb->prepare( "SELECT user_id FROM wp_usermeta WHERE meta_key = %s;", $hash );
			$user_id = $wpdb->get_var( $sql );

		    if( ! empty( $user_id ) ) {
				return( new Instructor( $user_id ) );
		    } else {
			    return false;
		    }
	    }

	    public static function instructor_by_login( $login ) {
		    $user = get_user_by( 'login', $login );
		    if( ! empty( $user ) ) {
			    // relying on core's caching here
			    return( new Instructor( $user->ID ) );
		    } else {
			    return false;
		    }
	    }

	    public static function create_hash( $user_id ) {
		    $user = get_user_by( 'id', $user_id );
		    $hash = md5( $user->user_login );

		    /*
		     * Just in case someone is actually using this hash for something,
		     * we'll populate it with current value. Will be an empty array if
		     * nothing exists. We're only interested in the key anyway.
		     */
		    update_user_meta( $user->ID, $hash, get_user_meta( $user->ID, $hash ) );
	    }

    }

}
?>