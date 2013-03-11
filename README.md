#What is it?

Combine several RSS feeds from your favorite housing agency and browse them on a Google Map.

Static demo at <http://flathunter.s3-website-us-east-1.amazonaws.com/index.html>

* Icons are color coded according to your preferred rent level (see the *config-example.php* for settings).

* Places of interest (using Google Places) shown around map center. Currently grocery stores and pubs are shown.

* Add support for a new housing agency by creating a class in *lib/modules/AGENCY_URL.php*. See existing Foxtons.co.uk class for example.

* Clicking on an ad shows the description to the right along with the public transit route (using Google Transit). Nice for checking how long it would take to get to work.

* Possibility to add favorites or remove unwanted properties.

* Filter for different rent levels.

* Support for currency conversion (not yet implemented)

#License

All code licensed under the GPL (any version) <http://www.gnu.org/licenses/gpl.html>

Icons by Nicolas Mollet released under Creative Commons 3.0 BY-SA <http://mapicons.nicolasmollet.com/>

#Screenshots

<img src="http://dl.dropbox.com/u/1236795/flathunter.png" />

# Configuration

- *GOOGLE_MAP_CENTER* Starting position of the Google map

- *GOOGLE_MAP_TRANSIT_DEST* The destination when doing Google Transit lookups. Change this to your work address

- *CURRENCY_CACHE_FILE* Where to cache Yahoo Finance lookups

- *CURRENCY_SIGN* Currency sign to put in the property marker icons

- *MAGPIE_CACHE_DIR* Where to cache MagpieRSS (RSS library) files

- *MAGPIE_CACHE_ON* Whether to cache RSS or not (preferred to cache, since otherwise you scrape the target website too often)

- *MONTHLY_INCOME* Your monthly income (use the same currency as the ads are listed in). Will determine rent level and the "rent to salary" percentage in the icons.

- *HIGH_RENT_LEVEL* Defines what is a "high" rent level (default 75% of disposable income)

- *MEDIUM_RENT_LEVEL* Defines what is a "medium" rent level (default 50% of disposable income)

- *$searches* List of RSS feeds to pull

# Requirements

The back-end for favorites/hiding properties requires MongoDB. The name of the MongoDB database is in *config-example.php*

**Note:** Google Transit is not available in all cities.
