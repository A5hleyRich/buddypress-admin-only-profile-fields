module.exports = function(grunt) {

	var pot_keywords = ['gettext', '__', '_e', '_n:1,2', '_x:1,2c', '_ex:1,2c', '_nx:4c,1,2', 'esc_attr__', 'esc_attr_e', 'esc_attr_x:1,2c', 'esc_html__', 'esc_html_e', 'esc_html_x:1,2c', '_n_noop:1,2', '_nx_noop:3c,1,2', '__ngettext_noop:1,2'];

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		uglify: {
			build: {
				files: [{
					expand: true,
					cwd: 'js/',
					src: ['*.js', '!*.min.js'],
					dest: 'js/',
					ext: '.min.js'
				}]
			}
		},
		pot: {
			build: {
				options: {
					text_domain: 'bp_admin_only_profile_fields',
					dest: 'languages/bp_admin_only_profile_fields.pot',
					keywords: pot_keywords,
					encoding: 'UTF-8',
					package_name: 'buddypress-admin-only-profile-fields',
					package_version: '',
					msgid_bugs_address: 'hello@ashleyrich.com',
					comment_tag: 'translators:'
				},
				files: [{
					expand: true,
					cwd: '',
					src:  [
						'*.php'
					]
				}]
			}
		},
		watch: {
			js: {
				files: ['js/*', '!js/*.min.js'],
				tasks: ['uglify']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-pot');

	grunt.registerTask('default', ['uglify', 'pot']);
};
