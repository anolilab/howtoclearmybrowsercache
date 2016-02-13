module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    webfont: {
      icons: {
        src: 'icons/*.svg',
        dest: 'public/assets/fonts',
        options: {}
      }
    }
  });

  grunt.loadNpmTasks('grunt-webfont');

  // Default task(s).
  grunt.registerTask('default', ['webfont']);
};
