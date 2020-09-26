<template>
    <div v-html="row.category_image_link"></div>
</template>


<script>
    export default {
        props: ['row'],
    }
</script>
