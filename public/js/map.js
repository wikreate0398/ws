var YMap = function(){
    var myMap = 'test';
    var myPlacemark;
    var self = this;
    this.initMap = function () {

        myMap = new ymaps.Map("map", {
            center: [55.755814, 37.617635],
            zoom: 7
        });

        var coords = $('input#placemark').val();
        var iconCaption = $('#map').attr('data-name');
        if (coords != '')
        {
            self.createPlacemark(coords.split(","), iconCaption);
        }

       myMap.events.add("click", function (e) {
            var coords = e.get('coords');
            $('input#placemark').val(coords);
            self.createPlacemark(coords, iconCaption);
        });
    };

    this.createPlacemark = function (coords, iconCaption) {
        if (myPlacemark) {
            myPlacemark.geometry.setCoordinates(coords);
        } else{

            myPlacemark = new ymaps.Placemark(coords, {
                iconCaption: iconCaption
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });

            myMap.geoObjects.add(myPlacemark);
            myMap.setCenter(coords);
        }
    };
}

var YMapClass = new YMap();
ymaps.ready(YMapClass.initMap);