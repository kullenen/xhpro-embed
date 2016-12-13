# Embedded Xhprof profiler

## Description

_Just for fun_

## Requirements

xhprof php extension, see [http://php.net/manual/en/xhprof.installation.php](http://php.net/manual/en/xhprof.installation.php)

## Installation

	composer require kullenen/xhprof-embed
	
## Usage

### Quick start

* Copy file vendor/kullenen/xhprof-embed/xhprof-embed.ini to web application document root
* Run your web application
* Go to http://(you web app host)/xhprof-embed

### Configuration

Profiler reads configuration from php script working dirrectory.
For example in web application this is a document root.

Copy file vendor/kullenen/xhprof-embed/xhprof-embed.ini to web application document root
(or working dirrectory of php script).

#### [common] section

* storage - Change value to 'XhprofEmbed\Storage\DefaultFileStorage' if you want use default xhprof file format.

#### [profiler] section

* active - 1 or 0, on/off profiler autorun
* flags['name of flag'] - 1 of 0, xhprof flag, see [http://php.net/manual/en/xhprof.constants.php](http://php.net/manual/en/xhprof.constants.php)
* filtering - 1 or 0, on/off filtering by $_SERVER vars or global $argv variable,
if filtering is off then xhprof profiler starts at every request, otherwise it starts according to filters
* _server_filters['name of variable'] - reqular expression on $_SERVER variable
* argv_filters['index of command line argument'] - reqular expression on $argv command line argument

#### [gui] section

* hookUrl - path to profiler gui. For example, if your web app host is 'myhost'
then profiler gui will show at http://myhost/xhprof-embed (by default)


