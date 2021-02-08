<template>
    <div>
        <router-view :sentinel="sentinel"></router-view>
    </div>
</template>


<script>

export default {
    props: ['sentinel'],
    data(){
        return{
        }
    },
    components: {
    }
}
</script>
