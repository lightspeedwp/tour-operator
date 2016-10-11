var gulp = require('gulp');

gulp.task('default', function() {	 
	console.log('Use the following commands');
	console.log('--------------------------');
	console.log('gulp sass				to compile the style.scss to style.css');
	console.log('gulp admin-sass		to compile the admin.scss to admin.css');
	console.log('gulp scporder-sass		to compile the scporder.scss to scporder.css');
	console.log('gulp compile-sass		to compile both of the above.');
	console.log('gulp js				to compile the custom.js to custom.min.js');
	console.log('gulp scporder-js		to compile the scporder.js to scporder.min.js');
	console.log('gulp compile-js		to compile both of the above.');
	console.log('gulp watch				to continue watching all files for changes, and build when changed');
	console.log('gulp wordpress-lang	to compile the tour-operator.pot, en_EN.po and en_EN.mo');
	console.log('gulp reload-node-flag-icon-css		copy the scss and svg files for the flag-icon-css');
});

var sass = require('gulp-sass');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sort = require('gulp-sort');
var wppot = require('gulp-wp-pot');
var gettext = require('gulp-gettext');

gulp.task('sass', function () { 
    gulp.src('assets/css/style.scss')
        .pipe(sass())
        .pipe(gulp.dest('assets/css/'));   
});

gulp.task('admin-sass', function () { 
    gulp.src('assets/css/admin.scss')
        .pipe(sass())
        .pipe(gulp.dest('assets/css/'));   
});

gulp.task('scporder-sass', function () { 
    gulp.src('assets/css/scporder.scss')
        .pipe(sass())
        .pipe(gulp.dest('assets/css/'));   
});

gulp.task('js', function () {
	gulp.src('assets/js/custom.js')	 
	//.pipe(jshint())	 
	//.pipe(jshint.reporter('fail'))	 
	.pipe(concat('custom.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('assets/js'));
});

gulp.task('scporder-js', function () {
	gulp.src('assets/js/scporder.js')	 
	//.pipe(jshint())	 
	//.pipe(jshint.reporter('fail'))	 
	.pipe(concat('scporder.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('assets/js'));
});
 
gulp.task('compile-sass', (['sass', 'admin-sass', 'scporder-sass']));
gulp.task('compile-js', (['js', 'scporder-js']));

gulp.task('watch', function() {	 
	gulp.watch('assets/css/style.scss', ['sass']);	 
	gulp.watch('assets/css/admin.scss', ['admin-sass']);
	gulp.watch('assets/css/scporder.scss', ['scporder-sass']);
	gulp.watch('assets/js/custom.js', ['js']);
	gulp.watch('assets/js/scporder.js', ['scporder-js']);
});

gulp.task('wordpress-pot', function () {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'tour-operator',
			destFile: 'tour-operator.pot',
			package: 'tour-operator',
			bugReport: 'https://github.com/lightspeeddevelopment/tour-operator/issues',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages'));
});

gulp.task('wordpress-po', function () {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'tour-operator',
			destFile: 'en_EN.po',
			package: 'tour-operator',
			bugReport: 'https://github.com/lightspeeddevelopment/tour-operator/issues',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages'));
});

gulp.task('wordpress-po-mo', ['wordpress-po'], function() {
	return gulp.src('languages/en_EN.po')
		.pipe(gettext())
		.pipe(gulp.dest('languages'));
});

gulp.task('wordpress-lang', (['wordpress-pot', 'wordpress-po-mo']));

gulp.task('reload-node-flag-icon-css', function() {
	gulp.src('node_modules/flag-icon-css/sass/*').pipe(gulp.dest('assets/css/flag-icon-css').on('error', function (err) {console.log('Error!', err);}));
	gulp.src('node_modules/flag-icon-css/flags/**/*').pipe(gulp.dest('assets/flags').on('error', function (err) {console.log('Error!', err);}));
});