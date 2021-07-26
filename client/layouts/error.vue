<template>
  <div class="error-description">
    <div class="catalog-slider__wrapper">
      <div class="container">
        <h1 v-if="error.statusCode === 404">{{ $t('ouch1') }}</h1>
        <h1 v-else>{{ $t('ouch2') }}</h1>
        <NuxtLink to="/" class="dark-link">{{ $t('to_main') }}</NuxtLink>  
      </div>
    </div>    
  </div>
</template>

<script>

export default {
  props: ['error'],
  name: 'error',  
}
</script>

<style scoped lang="scss">
  .error-description{
    .catalog-slider__wrapper{
      padding: 30px 0;
      min-height: 150px;
    }
  }  
</style>