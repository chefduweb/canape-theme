module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    uglify: {
      build: {
        src: 'app/assets/css/app.css',
        dest: 'app/assets/css/app.min.css'
      }
    },

    /* Plain ol' Sass function, so we can drop compass as a dependency: */
    sass: {                              
      dist: {                            
        options: {                       
          style: 'expanded',
          loadPath: require('node-bourbon').includePaths,
          loadPath: require('node-neat').includePaths
        },
        files: {                         
          'app/assets/css/app.css': 'sass/app.scss',
        }
      }
    },

    cssmin: {
      combine: {
        files: {
          'app/assets/css/app.min.css': 'app/assets/css/app.css'
        }
      }
    },

    browserSync: {
      dev: {
        bsFiles: {
          src : [
            'assets/css/*.css',
            'app/**/*.php',
            'app/*.php',
            'js/*.js'
          ]
        },
            
        options: {
          watchTask: true,
          proxy: 'localhost:8888',
        }
      }
    },

    watch: {
      css: {
        files: ['sass/*.scss', 'sass/**/*.scss'],
        tasks: ['sass']
      }
    }

  });


  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch')
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-browser-sync');


  grunt.registerTask('responsive', ['browserSync', 'watch'] );
  grunt.registerTask('live', ['browserSync', 'watch'] );


  // Default task(s).
  grunt.registerTask('default', ['sass'] );
  grunt.registerTask('build', ['sass', 'cssmin']);


  grunt.registerTask('minify-js', ['concat', 'uglify']);
  grunt.registerTask('minify-css', ['concat'])

};
