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
                        cwd: 'assets/unminified/css/',
                        src: [
                                '*.css',
                                '!*-rtl.css',
                                '!customizer-controls.css',
                                '!font-awesome.css',
                            ],
                        dest: 'assets/unminified/css', 
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
                    {
                        'style.css': 'assets/unminified/sass/style.scss'
                    },
                    {
                        'assets/unminified/css/editor-style.css': 'assets/unminified/sass/editor-style.scss'
                    },
                    // /* Small Footer Layouts */
                    // {
                    //     expand: true,
                    //     cwd: 'sass/site/footer/small-footer/',
                    //     src: ['**.scss'],
                    //     dest: 'assets/css/unminified', 
                    //     ext: '.css'
                    // },

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
                    'assets/unminified/css/style.css'
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
                    dest: 'assets/minified/js',
                    cwd: 'assets/unminified/js',
                    ext: '.min.js'
                }, { // all .js to .bhari.min.js
                    src: [
                        'assets/unminified/js/**.js',

                        //  Avoid customizer files
                        '!assets/unminified/js/customizer.js',
                        '!assets/unminified/js/customizer-preview.js',
                    ],
                    dest: 'assets/minified/js/bhari.min.js',
                    // cwd: 'assets/unminified/js/',
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
                    dest: 'assets/minified/css',
                    cwd: 'assets/unminified/css',
                    ext: '.min.css'
                }, { // .css to ultimate.min.css
                    src: [
                        'style.css'
                    ],
                    dest: 'assets/minified/css/style.min.css'
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
                    '!style - Copy.css',
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
                    '!codesniffer.ruleset.xml',
                ],
                dest: 'bhari/'
            }
        },

        compress: {
            main: {
                options: {
                    archive: 'bhari.zip',
                    mode: 'zip'
                },
                files: [
                    {
                        src: [
                            './bhari/**'
                        ]

                    }
                ]
            }
        },

        clean: {
            main: ["bhari"],
            zip: ["bhari.zip"]

        },

        makepot: {
            target: {
                options: {
                    domainPath: '/',
                    potFilename: 'languages/bhari.pot',
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
                textdomain: 'bhari',
            },
            target: {
                files: {
                    src: [
                        '*.php',
                        '**/*.php',
                        '!node_modules/**',
                        '!php-tests/**',
                        '!bin/**',
                        '!admin/bsf-core/**'
                    ]
                }
            }
        }
    });

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
