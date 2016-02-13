module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON(‘package.json’),
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
