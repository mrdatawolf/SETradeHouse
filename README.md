![alt text](https://github.com/mrdatawolf/SETradeHouse/blob/master/public/img/SETradeHouse_logo_core.png?raw=true)
# SE TradeHouse [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

> Tradehouse for Space Engineers

A standalone web service allowing users to see trade data from participating Space Engineers (SE) Servers.  The goal is to display data to help a user smartly position themselves in their choosen SE Server's markets. Whether the user is running their own trades or are simply looking to maximze their profits; this system will help them understand the market forces in play and give guidance on the setting up the best trade positions.
 
##Development setup Quick Start (for local development and testing)
1. It is now built on laravel 8 so get that running.
2. Do composer update
3. Configure your .env to handle your dbs etc.
4. run ```php artisan migrate:fresh```
5. You will need to add the initial user to the db (by hand for now)
6. run ```php artisan db:seed```
7. Let me know what I missed here :)

##Current Roadmap
Road to 1.0 MVP
1. ~~Setup a sqlite database to be able to develop against.~~
2. ~~Populate the db with base values that are not built from other data.  This is the constants i the game like server refinery efficiency.~~
3. ~~Make a frontend for developers to see the current DB data.~~ see rawdata link
4. ~~Make a clone of the spreadsheet we have been using.~~
5. ~~Create all the code needed to derive the numbers shown on the spreadsheet.~~
6. ~~Align all values to the current spreadsheet as a proof that the system is working.~~
7. ~~Get the spreadsheet page to allow the trade station amounts/values to be created/updated as needed (for testing).~~
8. ~~Process data from the game server~~
9. ~~Bring it up on a server online.~~
10. ~~Get the active servers data being ingested.~~
11. ~~Open it up so anyone can interact with the test system.~~
12. ~~Allow touch devices to interact with the pages.~~
13. ~~Fix the GPS pull.~~
14. ~~Convert SQL files to migrations/seeders.~~
 
##Future Roadmap
1.  Revised +1.0 goals.
    1. ~~Expand the active and inactive transactions to use all columns.~~
    2. ~~Add a three.js map of the system.~~
    3. Add sheets as needed to flesh out the user experience. Anything that can help the users visualize or work with the data.
    4. Have the three.js map show current  store locations.
    5. Add a thrust to weight calculator.
    6. Add a blueprint breakdown. It would take a blueprint file and tell the user the comps, ingots, ores needed (user choice). It would also breakdown the prices based on server averages.
    7. Add API to get current trade data on a public store.
    8. Add weights to transactions based on distances from world to world.
    9. Improve the user system.
    10. ~~Get the ticker working~~.
    11. A Map Generator showing cluster servers and their tradezones. Or maybe just a common format for making a diagram for the users.
    12. There's alot more but where we go will depend on where the people helping see the project going from here.

##Notes
We have started moving to livewire. 1d

## Contributing

1. Fork it (<https://github.com/mrdatawolf/SETradeHouse/fork>)
2. Create your feature branch (`git checkout -b feature/fooBar`)
3. Commit your changes (`git commit -am 'Add some fooBar'`)
4. Push to the branch (`git push origin feature/fooBar`)
5. Create a new Pull Request

<!-- Markdown link & img dfn's -->
[wiki]: https://github.com/mrdatawolf/SETradeHouse/wiki

##Special Thanks to
1. Braelok for the innumerable hours he poured into trade in the SE worlds and for teaching me the ways of SE economies.  This could not exist without his work!
2. The Nebulon Cluster crew for showing me how much an economy adds to SE!
3. The Frontier Economy Mod for making a great econ mod!
4. Hobobot, MCI, Azure Night Owl and everyone else who made the Torch Econ Plugin!
5. The Expanse for bringing in the power of a mutli-server cluster of SE servers! And for getting the torch econ mod working in their system!  
