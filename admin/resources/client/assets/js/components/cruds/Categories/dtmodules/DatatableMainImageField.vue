<template>
    <div v-html="row.main_image_link"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
