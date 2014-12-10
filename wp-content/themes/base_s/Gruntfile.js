'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: ['assets/styles/**/*.{scss,sass}'],
                tasks: ['sass', 'autoprefixer', 'cssmin']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify']
            },
            images: {
                files: ['assets/images/**/*.{png,jpg,gif}'],
                tasks: ['imagemin']
            },
            livereload: {
                options: { livereload: true },
                files: ['main.css', 'assets/styles/build/print.css', 'assets/styles/build/main.css', 'assets/js/*.js', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}', '*.php', 'partials/*.php']
            }
        },

        // sass
        sass: {
            dist: {
                options: {
                    sourcemap: 'none',
                    style: 'expanded',
                },
                files: {
                    'assets/styles/build/main.css': 'assets/styles/main.scss',
                    'assets/styles/build/editor-style.css': 'assets/styles/editor-style.scss',
                    'assets/styles/build/print.css': 'assets/styles/print.scss',
                }
            }
        },

        // autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
                map: false
            },
            files: {
                expand: true,
                flatten: true,
                src: 'assets/styles/build/*.css',
                dest: 'assets/styles/build'
            },
        },

        // css minify
        cssmin: {
            options: {
                keepSpecialComments: 1
            },
            minify: {
                expand: true,
                cwd: 'assets/styles/build',
                src: ['*.css', '!*.min.css'],
                dest: 'assets/styles/build',
                ext: '.css'
            }
        },

        // javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                "force": true
            },
            all: [
                'Gruntfile.js',
                'assets/js/source/**/*.js',
                'assets/js/funds/*.js'
            ]
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            plugins: {
                options: {
                    sourceMap: true
                },
                files: {
                    'assets/js/plugins.min.js': [
                        'assets/js/vendor/respond.min.js',
                        'assets/js/vendor/modernizr.custom.51814.js',
                        'assets/js/vendor/waypoints.min.js',
                        'assets/js/vendor/waypoints-sticky.min.js',
                        'assets/js/vendor/css_browser_selector.js',
                        'assets/js/vendor/clamp.min.js',
                        'assets/js/vendor/jquery.validate.min.js'
                    ]
                }
            },
            main: {
                options: {
                    sourceMap: true
                },
                files: {
                    'assets/js/main.min.js': [
                        'assets/js/source/jquery.hmc-removetel.js',
                        'assets/js/source/main.js'
                    ],

                }
            }
        },

        // image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true,
                    interlaced: true
                },
                files: [{
                    expand: true,
                    cwd: 'images/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'images/'
                }]
            }
        },

        // deploy via rsync
        deploy: {
            options: {
                src: "./",
                args: ["--verbose"],
                exclude: ['.git*', 'node_modules', '.sass-cache', 'Gruntfile.js', 'package.json', '.DS_Store', 'README.md', 'config.rb', '.jshintrc'],
                recursive: true,
                syncDestIgnoreExcl: true
            },
            staging: {
                 options: {
                    dest: "~/path/to/theme",
                    host: "user@host.com"
                }
            },
            production: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@host.com"
                }
            }
        }

    });

    // rename tasks
    grunt.renameTask('rsync', 'deploy');

    // register task
    grunt.registerTask('default', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'imagemin', 'watch']);

};
