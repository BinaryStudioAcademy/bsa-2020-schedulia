<template>
  <div class="event-info-content">
    <VAvatar size="70px">
      <img
        src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460"
        alt="Avatar"
      />
    </VAvatar>
    <h4>Michael Scott</h4>
    <p>Sales manager</p>
  </div>
</template>

<script>
export default {
  name: "OwnerData",
};
</script>

<style>
.event-info-content {
  margin-top: -50px;
  padding-left: 50px;
}

.event-info-content h4 {
  margin-top: 15px;
}
</style>
