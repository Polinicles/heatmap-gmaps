# Heatmap-Gmaps


![Packagist](https://img.shields.io/packagist/l/doctrine/orm.svg)
![gmaps-api](https://img.shields.io/badge/gmaps-3-brightgreen.svg)

The following instructions show how to implement a Heatmap layer and Squares or Circles from [Gmaps API](https://developers.google.com/maps/documentation/javascript/tutorial).


## Getting Started

### Prerequisites

A valid [Gmaps key](https://developers.google.com/maps/documentation/javascript/get-api-key) will be necessary in order to run the map. Put the key at the end of `index.php` where you'll see  `{YOUR_API_KEY}` 

### Initialize environment

We can use a simple **php** server

```
php -S localhost:8080
```

Check if it's working on [http://localhost:8080](http://localhost:8080)

## Testing

The use is very simple. It gets the data from `data.json` and prints a temperature or rain layer depending which button you click on.  Also, a fixed image layer has been added (every button displays a different layer).

### Temperature layer

You can switch between two [shapes](https://developers.google.com/maps/documentation/javascript/shapes), **circles or squares**, by commenting or uncommenting the lines from the `defineShapesLayer()` function.

A gradient of 36 different colors is implemented to show the temperature range.
 
 In this case, the temperature value is based on a range of temperatures from -26º to 46º Celsius grades using 2 grades steps, so we get 36 ranges.
 Feel free to use your range and gradient.

### Rain layer

The rain layer uses a gradient instead of shapes. The layer can be [customized](https://developers.google.com/maps/documentation/javascript/heatmaplayer) by changing the values of `maxIntensity` or `radius`.

The gradient selected only has 3 colors (first has 0 opacity).
