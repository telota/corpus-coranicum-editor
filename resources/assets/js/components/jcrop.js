exports.getRelativeCoordinates = function(coordinates, bounds) {
  let relativeCoordinates = {};

  for (let key in coordinates) {
    if (key.includes('x') || key.includes('w')) {
      let value = coordinates[key] / bounds[0];
      value = value * 100;
      relativeCoordinates[key] = parseFloat(value.toFixed(3));
    }

    if (key.includes('y') || key.includes('h')) {
      let value = coordinates[key] / bounds[1];
      value = value * 100;
      relativeCoordinates[key] = parseFloat(value.toFixed(3));
    }
  }

  return relativeCoordinates;
};
