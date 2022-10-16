<template>
    <div id="map"></div>
</template>

<script>
export default {
    mounted(){
        console.assert(!window.google, "window.google is undefined")

        const canvas = document.getElementById("map");

        //to rnot show google maps
        /*if(1){
            canvas.style.display = 'none';
            return;
        }*/

        window.initMap = function() {
            // The location of Uluru
            const uluru = { lat: -25.344, lng: 131.036 };
            // The map, centered at Uluru
            const map = new window.google.maps.Map(canvas, {
                zoom: 4,
                center: uluru,
            });
            // The marker, positioned at Uluru
            new window.google.maps.Marker({
                position: uluru,
                map: map,
            });
        }
    }
}
</script>

<style lang="scss">

#map{
    width: 100%;
    height: min(calc(100vw*0.6), 800px);
}

</style>
