<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted"             => "The :attribute must be accepted.",
    "active_url"           => "The :attribute is not a valid URL.",
    "after"                => "The :attribute must be a date after :date.",
    "alpha"                => "The :attribute may only contain letters.",
    "alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_num"            => "The :attribute may only contain letters and numbers.",
    "array"                => "The :attribute must be an array.",
    "before"               => "The :attribute must be a date before :date.",
    "between"              => [
        "numeric" => "The :attribute must be between :min and :max.",
        "file"    => "The :attribute must be between :min and :max kilobytes.",
        "string"  => "The :attribute must be between :min and :max characters.",
        "array"   => "The :attribute must have between :min and :max items.",
    ],
    "boolean"              => "The :attribute field must be true or false.",
    'captcha'              => 'The security image was not answered correctly',
    'css'                  => 'The custom CSS did not pass validation.',
    "confirmed"            => "The :attribute confirmation does not match.",
    "date"                 => "The :attribute is not a valid date.",
    "date_format"          => "The :attribute does not match the format :format.",
    "different"            => "The :attribute and :other must be different.",
    "digits"               => "The :attribute must be :digits digits.",
    "digits_between"       => "The :attribute must be between :min and :max digits.",
    "email"                => "The :attribute must be a valid email address.",
    "filled"               => "The :attribute field is required.",
    "file_name"            => "The :attribute is not a valid file name.",
    "file_integrity"       => "The :attribute attachment fails integrity checks and may be corrupt or invalid.",
    "file_new"             => "The :attribute must be an unrecognized file.",
    "file_old"             => "The :attribute must have been uploaded before.",
    "exists"               => "The selected :attribute is invalid.",
    "image"                => "The :attribute must be an image.",
    "in"                   => "The selected :attribute is invalid.",
    "integer"              => "The :attribute must be an integer.",
    "ip"                   => "The :attribute must be a valid IP address.",
    "md5"                  => "The :attribute must be a valid MD5 hash.",
    "max"                  => [
        "numeric" => "The :attribute may not be greater than :max.",
        "file"    => "The :attribute may not be greater than :max kilobytes.",
        "string"  => "The :attribute may not be greater than :max characters.",
        "array"   => "The :attribute may not have more than :max items.",
    ],
    "mimes"                => "The :attribute must be a file of type: :values.",
    "min"                  => [
        "numeric" => "The :attribute must be at least :min.",
        "file"    => "The :attribute must be at least :min kilobytes.",
        "string"  => "The :attribute must be at least :min characters.",
        "array"   => "The :attribute must have at least :min items.",
    ],
    "not_in"               => "The selected :attribute is invalid.",
    "numeric"              => "The :attribute must be a number.",
    "regex"                => "The :attribute format is invalid.",
    "required"             => "The :attribute field is required.",
    "required_if"          => "The :attribute field is required when :other is :value.",
    "required_with"        => "The :attribute field is required when :values is present.",
    "required_with_all"    => "The :attribute field is required when :values is present.",
    "required_without"     => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "same"                 => "The :attribute and :other must match.",
    "size"                 => [
        "numeric" => "The :attribute must be :size.",
        "file"    => "The :attribute must be :size kilobytes.",
        "string"  => "The :attribute must be :size characters.",
        "array"   => "The :attribute must contain :size items.",
    ],
    "unique"               => "The :attribute has already been taken.",
    "url"                  => "The :attribute format is invalid.",
    "timezone"             => "The :attribute must be a valid zone.",
    "password"             => "The :attribute is incorrect.",

    'css'                  => "The CSS you've supplied contains references that are not allowed.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'file_corrupt'   => "<tt>:filename</tt> is corrupt or has an invalid file name.",
        'file_generic'   => "Your file could not be uploaded",
        'post_flood'     => "{1}You you must wait <strong>:time_left</strong> second before posting again.|[2,Inf]You you must wait <strong>:time_left</strong> seconds before posting again.",
        'thread_flood'   => "{1}You you must wait <strong>:time_left</strong> second before creating a new thread.|[2,Inf]You you must wait <strong>:time_left</strong> seconds before creating a new thread.",

        'banned'         => "You are banned!",
        'banned_for'     => "Reason: <em>:reason</em>",

        'integrity'      => "Your file's integrity cannot be verified.",

        'unoriginal_content'      => "Unoriginal content!",
        'unoriginal_image_thread' => "File <tt>:filename</tt> <a href=\":url\">already exists</a> in this thread.",
        'unoriginal_image_board'  => "File <tt>:filename</tt> <a href=\":url\">already exists</a> in this board.",

        'board_uri_banned' => "The requested URI is reserved by administration.",

        // For duplicate posts.
        'same_as_last_post' => "This post is the same one as the last one in this thread.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Specific Language
    |--------------------------------------------------------------------------
    |
    | These lines are particular to a single, unique instance of a form.
    |
    */

    'form' => [

        /**
         * Post Form
         */
        'post' => [

            // Body content.
            'body' => [

                // Newline requirement
                'newlines' => "[0,1]Post body must be exactly :count line.|[2,Inf]Post body must have fewer than :count lines.",

            ],

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
