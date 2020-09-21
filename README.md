
# FPL Data Updater

Pulls down the latest data from the [Fantasy Premier League](https://fantasy.premierleague.com/) website.

Writes the data as `JSON` into the [data](https://github.com/Package/FPL-Data-Update/tree/master/data) directory on completion, and can also write the data into a [MongoDB](https://www.mongodb.com/) database.

Data extracted contains information on:
* Players
* Teams
* Gameweeks
* Fixtures + Scores

## Usage

#### To Install
1. Clone Repository
2. `composer install` to grab dependencies

#### To Run 
`php index.php COMMAND_NAME COMMAND_ARGS`

Where `COMMAND_NAME` is one of:

`fpl:update all` - exports all data from FPL.

`fpl:update teams` - exports latest player position data.

`fpl:update positions` - exports latest player position data.

`fpl:update players` - exports latest player data.

`fpl:update gameweeks` - exports latest game week data.

`fpl:update fixtures` - exports latest fixture data.


`save-teams` - saves latest exported team data to MongoDB

`save-gameweeks` - saves latest exported gameweek data to MongoDB  

## Notes
* Requires PHP 7.2+
* PHP added to PATH.
* [php_mongodb](https://pecl.php.net/package/mongodb) extension appropriate for your setup if you want to store the export into MongoDB.

