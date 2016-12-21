module.exports = function (grunt) {
    'use strict';
    // Project configuration
    var autoprefixer = require('autoprefixer');
    var flexibility = require('postcss-flexibility');

    grunt.initConfig({
            pkg: grunt.file.readJSON('package.json'),

            rtlcss: {
                options: {
                    // rtlcss options
                    config: {
                        preserveComments: true,
                        greedy: true
                    },
                    // generate source maps
                    map: false
                },
                dist: {
                    files: [
                         {
                            expand: true,
                            cwd: 'assets/css/unminified/',
                            src: [
                                    '*.css',
                                    '!*-rtl.css',
                                    '!customizer-controls.css',
                                    '!font-awesome.css',
                                    '!font-awesome.css',
                                ],
                            dest: 'assets/css/unminified', 
                            ext: '-rtl.css'
                            
                        },
                    ]
                }/*
                'default': {
                    
                    files: {
                        'assets/css/unminified/rtl.css': [
                            'assets/css/unminified/style.css'
                        ]
                    }
                }*/
            },

            sass: {
                options: {
                    sourcemap: 'none',
                    outputStyle: 'expanded'
                },
                dist: {
                    files: [
                        /*{
                        'style.css': 'sass/style.scss'
                        },*/
                        /* Common Style */
                        {
                            expand: true,
                            cwd: 'sass/',
                            src: ['style.scss'],
                            dest: 'assets/css/unminified', 
                            ext: '.css'
                            
                        },
                        /* Header Layouts */
                        {
                            expand: true,
                            cwd: 'sass/site/header/header-layouts/',
                            src: ['**.scss'],
                            dest: 'assets/css/unminified', 
                            ext: '.css'
                            
                        },
                        /* Blog Layouts */
                        {
                            expand: true,
                            cwd: 'sass/site/blog/blog-layouts/blog-styles/',
                            src: ['**.scss'],
                            dest: 'assets/css/unminified', 
                            ext: '.css'
                            
                        },
                        /* Single Blog Post Single Layouts */
                        {
                            expand: true,
                            cwd: 'sass/site/blog/single-post-layouts/single-post-styles/',
                            src: ['**.scss'],
                            dest: 'assets/css/unminified', 
                            ext: '.css'
                        },
                        /* Small Footer Layouts */
                        {
                            expand: true,
                            cwd: 'sass/site/footer/small-footer/',
                            src: ['**.scss'],
                            dest: 'assets/css/unminified', 
                            ext: '.css'
                        },

                    ]
                }
            },

            postcss: {
                options: {
                    map: false,
                    processors: [
                        flexibility,
                        autoprefixer({
                            browsers: [
                                'Android >= 2.1',
                                'Chrome >= 21',
                                'Edge >= 12',
                                'Explorer >= 7',
                                'Firefox >= 17',
                                'Opera >= 12.1',
                                'Safari >= 6.0'
                            ],
                            cascade: false
                        })
                    ]
                },
                style: {
                    expand: true,
                    src: [
                        'assets/css/unminified/style.css'
                    ]
                }
            },

            uglify: {
                js: {
                    files: [{ // all .js to min.js
                        expand: true,
                        src: [
                            '**.js'
                        ],
                        dest: 'assets/js/minified',
                        cwd: 'assets/js/unminified',
                        ext: '.min.js'
                    }, { // all .js to .astra.min.js
                        src: [
                            'assets/js/unminified/ast-masonry.js',
                            'assets/js/unminified/**.js',
                            '!assets/js/unminified/customizer-controls-toggle.js',
                            '!assets/js/unminified/customizer-controls.js',
                            '!assets/js/unminified/customizer-preview.js',
                        ],
                        dest: 'assets/js/minified/astra.min.js',
                        // cwd: 'assets/js/unminified/',
                    },
                    ]
                }
            },

            cssmin: {
                options: {
                    keepSpecialComments: 0
                },
                css: {
                    files: [{ //.css to min.css
                        expand: true,
                        src: [
                            '**/*.css'
                        ],
                        dest: 'assets/css/minified',
                        cwd: 'assets/css/unminified',
                        ext: '.min.css'
                    }, { // .css to ultimate.min.css
                        src: [
                            'style.css'
                        ],
                        dest: 'assets/css/minified/style.min.css'
                    }, { // .css to ultimate.min.css
                        src: [
                            'style.css',
                            'assets/css/unminified/*.css'
                        ],
                        dest: 'assets/css/minified/astra.min.css'
                    }]
                }
            },

            copy: {
                main: {
                    options: {
                        mode: true
                    },
                    src: [
                        '**',
                        '!node_modules/**',
                        '!build/**',
                        '!css/sourcemap/**',
                        '!.git/**',
                        '!bin/**',
                        '!.gitlab-ci.yml',
                        '!bin/**',
                        '!tests/**',
                        '!phpunit.xml.dist',
                        '!*.sh',
                        '!*.map',
                        '!Gruntfile.js',
                        '!package.json',
                        '!.gitignore',
                        '!phpunit.xml',
                        '!README.md',
                        '!sass/**',
                        '!codesniffer.ruleset.xml',
                    ],
                    dest: 'awesome-blog/'
                }
            },

            compress: {
                main: {
                    options: {
                        archive: 'awesome-blog.zip',
                        mode: 'zip'
                    },
                    files: [
                        {
                            src: [
                                './awesome-blog/**'
                            ]

                        }
                    ]
                }
            },

            clean: {
                main: ["awesome-blog"],
                zip: ["awesome-blog.zip"]

            },

            makepot: {
                target: {
                    options: {
                        domainPath: '/',
                        potFilename: 'languages/astra.pot',
                        potHeaders: {
                            poedit: true,
                            'x-poedit-keywordslist': true
                        },
                        type: 'wp-theme',
                        updateTimestamp: true
                    }
                }
            },
            
            addtextdomain: {
                options: {
                    textdomain: 'ast',
                },
                target: {
                    files: {
                        src: ['*.php', '**/*.php', '!node_modules/**', '!php-tests/**', '!bin/**', '!admin/bsf-core/**']
                    }
                }
            }

        }
    );

    // Load grunt tasks
    grunt.loadNpmTasks('grunt-rtlcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-wp-i18n');

    // rtlcss, you will still need to install ruby and sass on your system manually to run this
    grunt.registerTask('rtl', ['rtlcss']);

    // SASS compile
    grunt.registerTask('scss', ['sass']);

    // Style
    grunt.registerTask('style', ['scss', 'postcss:style', 'rtl']);

    // min all
    grunt.registerTask('minify', ['style', 'uglify:js', 'cssmin:css']);

    // Grunt release - Create installable package of the local files
    grunt.registerTask('release', ['clean:zip', 'copy', 'compress', 'clean:main']);

    // i18n
    grunt.registerTask('i18n', ['addtextdomain', 'makepot']);

    grunt.util.linefeed = '\n';
};
