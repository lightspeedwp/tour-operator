const gulp         = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const concat       = require('gulp-concat');
const gettext      = require('gulp-gettext');
const jshint       = require('gulp-jshint');
const minify       = require('gulp-minify-css');
const plumber      = require('gulp-plumber');
const rename       = require('gulp-rename');
const rtlcss       = require('gulp-rtlcss');
const sass         = require('gulp-sass');
const sort         = require('gulp-sort');
const sourcemaps   = require('gulp-sourcemaps');
const uglify       = require('gulp-uglify');
const gutil        = require('gulp-util');
const wppot        = require('gulp-wp-pot');

const browserlist  = ['last 2 version', '> 1%'];

gulp.task('default', function() {
	console.log('Use the following commands');
	console.log('--------------------------');
	console.log('gulp compile-css               to compile the scss to css');
	console.log('gulp compile-js                to compile the js to min.js');
	console.log('gulp watch                     to continue watching the files for changes');
	console.log('gulp wordpress-lang            to compile the tour-operator.pot, tour-operator-en_EN.po and tour-operator-en_EN.mo');
	console.log('gulp reload-node-flag-icon-css to copy the scss and svg files for the flag-icon-css');
});

gulp.task('styles', function () {
	return gulp.src('assets/css/scss/*.scss')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compact',
			includePaths: ['assets/css/scss']
		}).on('error', gutil.log))
		.pipe(autoprefixer({
			browsers: browserlist,
			casacade: true
		}))
		.pipe(sourcemaps.write('maps'))
		.pipe(gulp.dest('assets/css'))
});

gulp.task('styles-rtl', function () {
	return gulp.src('assets/css/scss/*.scss')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sass({
			outputStyle: 'compact',
			includePaths: ['assets/css/scss']
		}).on('error', gutil.log))
		.pipe(autoprefixer({
			browsers: browserlist,
			casacade: true
		}))
		.pipe(rtlcss())
		.pipe(rename({
			suffix: '-rtl'
		}))
		.pipe(gulp.dest('assets/css'))
});

gulp.task('styles-vendor', function () {
	return gulp.src('assets/css/vendor/**/*.scss')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sass({
			outputStyle: 'compact',
			includePaths: ['assets/css/vendor']
		}).on('error', gutil.log))
		.pipe(autoprefixer({
			browsers: browserlist,
			casacade: true
		}))
		.pipe(gulp.dest('assets/css/vendor'))
});

gulp.task('styles-vendor-rtl', function () {
	return gulp.src('assets/css/vendor/**/*.scss')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sass({
			outputStyle: 'compact',
			includePaths: ['assets/css/vendor']
		}).on('error', gutil.log))
		.pipe(autoprefixer({
			browsers: browserlist,
			casacade: true
		}))
		.pipe(rtlcss())
		.pipe(rename({
			suffix: '-rtl'
		}))
		.pipe(gulp.dest('assets/css/vendor'))
});

gulp.task('compile-css', gulp.series( ['styles', 'styles-rtl', 'styles-vendor', 'styles-vendor-rtl'] , function() { 
	console.log('Done');
}));

gulp.task('js', function() {
	return gulp.src('assets/js/src/**/*.js')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(jshint())
		.pipe(uglify())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('assets/js'))
});

gulp.task('js-vendor', function() {
	return gulp.src('assets/js/vendor/src/**/*.js')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(jshint())
		.pipe(uglify())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('assets/js/vendor'))
});

gulp.task('compile-js', gulp.series( ['js', 'js-vendor'] , function() { 
	console.log('Done');
}));

gulp.task('watch-css', function () {
	return gulp.watch('assets/css/**/*.scss', ['compile-css']);
});

gulp.task('watch-js', function () {
	return gulp.watch('assets/js/src/**/*.js', ['compile-js']);
});

gulp.task('watch', gulp.series( ['watch-css', 'watch-js'] , function() { 
	console.log('Done');
}));

gulp.task('wordpress-pot', function() {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'tour-operator',
			package: 'tour-operator',
			bugReport: 'https://github.com/lightspeeddevelopment/tour-operator/issues',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages/tour-operator.pot'))
});

gulp.task('wordpress-po', function() {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'tour-operator',
			package: 'tour-operator',
			bugReport: 'https://github.com/lightspeeddevelopment/tour-operator/issues',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages/tour-operator-en_EN.po'))
});

gulp.task('wordpress-po-mo', gulp.series( ['wordpress-po'] , function() { 
	return gulp.src('languages/tour-operator-en_EN.po')
		.pipe(gettext())
		.pipe(gulp.dest('languages'))
}));

gulp.task('wordpress-lang', gulp.series( ['wordpress-pot', 'wordpress-po-mo'] , function() { 
	console.log('Done');
}));

gulp.task('reload-node-flag-icon-css', function() {
	gulp.src('node_modules/flag-icon-css/sass/*').pipe(gulp.dest('assets/css/flag-icon-css').on('error', function (err) {console.log('Error!', err);}));
	gulp.src('node_modules/flag-icon-css/flags/**/*').pipe(gulp.dest('assets/flags').on('error', function (err) {console.log('Error!', err);}));
});