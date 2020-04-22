# Colonization
Foundation for a commodity based game
note: this version should fully replace the old spreadsheet system and allow for more flexiblity and a easier way for users to work with the data.
This version will be the foundation for future projects as such it's goals might stop before 2.0 and 2.0 might be another project using this as the foundation.

##Quick Start
1. You need php on your system.  At a command prompt run `php -v`
Your expecting to see something like
 `PHP 7.1.8 (cli) (built: Aug  1 2017 20:56:32) ( NTS MSVC14 (Visual C++ 2015) x64 )
 Copyright (c) 1997-2017 The PHP Group
 Zend Engine v3.1.0, Copyright (c) 1998-2017 Zend Technologies`
2. You might have to edit the php.ini and uncomment `extension=php_pdo_sqlite.dll` to use the sqlite db.
3. You need a copy of the code.  If you just want to check it out you can goto https://github.com/mrdatawolf/Colonization and use the "Clone or Download" button.  Otherwise you will need to clone it so you can begin working on it and make pull requests.
4. In the main directory you need to run "composer update" <-- this might mean you need to install composer.
5. To start the server for local development go into the folder you saved it to and run localWeb.bat (Windows).
6. Open a web browser and goto `http://localhost:8282`.  You should see simple set of links at the top of the page.

##Current Roadmap
Road to 1.0 MVP
1. ~~Setup a sqlite database to be able to develop against.~~
2. ~~Populate the db with base values that are not built from other data.  This is the constants i the game like server refinery efficiency.~~
3. ~~Make a frontend for developers to see the current DB data.~~ see rawdata link
4. ~~Make a clone of the spreadsheet we have been using.~~
5. ~~Create all the code needed to derive the numbers shown on the spreadsheet.~~
6. ~~Align all values to the current spreadsheet as a proof that the system is working.~~
6. Get the spreadsheet page to allow the station amounts/values to be created/updated as needed.
7. Make all the commands used on the spreadsheet available in an API.  This API should be updated with any new base/derived values we add.
8. Bring it up on a server so anyone can interact with the test system.

##Future Roadmap
1.  Revised +1.0 goals.
    1. Expand the active and inactive transactions to use all columns.
    2. Add weights to transactions based on distances from server to server.
    3. Add a user system.
    4. Add sheets as needed to flex out the user experience.
    5. Begin gathering the data from the Expanse to update the system with real world data.
2.  Goals and the future
    1. a map generator
    2. Which creates paths and splits the paths into sub points based on distance
    3. It needs to make port locations.
        1. It should make raw goods locations
        2. The raw goods should be shown with pictograms
        3. it needs to show player locations (maybe based on view range from player POV)
    4. a fighting system
        1. ship to ship
        2. ship to port()
3. 2.0 goals
    1. add bot "a.i." to also move commodities.
    2. add player ordered bots to move commodities.
4. 3.0 goals
    1. roles
    2. Ship to shore fighting
    3. allow upgrades at ports
    4. allow player made ports.
    5. Factions
4. 4.0 goals
    1. add more tasks to the bots (ai and player) such as interdiction or patrol.
    2. add api to allow players to add orders to their bots via other inputs (such as phone).


##Notes on the foundational logic we are shooting for...
![Clusters Example](https://raw.githubusercontent.com/mrdatawolf/Colonization/master/clusters_example.png)
#How a given item gets it's value for a trade-zone:
notes: cluster 1 is 1 server with 1 tradezone. cluster 2 is 10 servers, 4 of which have tradezones.  See image for layouts.
notes: A trade zone influences and is influenced by all the other trade-stations in the cluster (as long as there is any path to and/or from the other trade-stations. The amount of influence trade-stations have on each other is expressed as a "weight" for a given station.  Right now weight is based on how long they have been in system.
notes: We have moved to a tradehouse model.  So we look at the buy and sell orders in the tradezone, server, cluster.
1. Example 1:  In cluster 1 server 1 we have a tradestation (tz3) looking for 1,000,000 gold ore at 300 SC per.
