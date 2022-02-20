<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-full" style="background-color: #2196f3">
      <div class="container">
        <a class="navbar-brand" href="#" style="color:white;">E-Store 2 Go</a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarText"
          aria-controls="navbarText"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <router-link :to="{name:'home'}" class="nav-link"
                ><a>Home<span class="sr-only">(current)</span></a></router-link
              >
            </li>
            <li class="nav-item" >
              <a class="nav-link" style="color:white;" href="#">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pricing</a>
            </li>
          </ul>
          
        </div>
      </div>
     
    </nav>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
    .nav-link{
        color:white !important;
    }
</style>
