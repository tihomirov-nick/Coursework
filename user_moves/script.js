let center = [59.943462, 30.278678];

function init() {
    let map = new ymaps.Map('map-test', {
        center: center,
        zoom: 20
    });

    let placemark = new ymaps.Placemark(center, {}, {
        iconLayout: 'default#image',
        iconImageHref: 'https://image.flaticon.com/icons/png/512/64/64113.png',
        iconImageSize: [40, 40],
        iconImageOffset: [-19, -44]
    });

    map.controls.remove('geolocationControl'); // удаляем геолокацию
    map.controls.remove('searchControl'); // удаляем поиск
    map.controls.remove('trafficControl'); // удаляем контроль трафика
    map.controls.remove('typeSelector'); // удаляем тип
    map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
    map.controls.remove('rulerControl'); // удаляем контрол правил
    map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)

    map.geoObjects.add(placemark);
    map.geoObjects.add(new ymaps.Placemark([59.943462, 30.278678], {
            balloonContent: 'цвет <strong>влюбленной жабы</strong>'
        }
}

ymaps.ready(init);