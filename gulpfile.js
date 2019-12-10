/**
 * Gulp
 *
 * @author Alejandro Mostajo <info@10quality.com>
 * @package WPMVC
 * @license MIT
 * @version 1.0
 */

'use strict';

// Prepare
var fs = require('fs');
var gulp = require('gulp');
var wpmvc = require('gulp-wpmvc');

// Load package JSON as config file.
var config = JSON.parse(fs.readFileSync('./package.json'));
// Load wordpress-org JSON as config file.
var wordpressOrg = JSON.parse(fs.readFileSync('./wordpress-org.json'));

// Init WPMVC default tasks.
wpmvc(gulp, config, wordpressOrg);

// --------------
// START - CUSTOM TASKS