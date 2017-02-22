<template>
  <div class="container main team">
    <div class="text-center title">
      <h2>做一个有想法、有创造力<br />三观正的公司</h2>
      <p>创新和有点总是让人难以发现的，在技术与审美日新月异的今天，我们不在拘泥于<br />传统是思维的方法去展示。我们需要出众的美丽页面在展示我们自己的每一个地方，<br />同时也要保证高效率的运转，所以，来创建一个属于你的网站。</p>
    </div>
    <h3>我们的团队</h3>
    <div class="row">
      <div class="col-md-3">
        <a href="7_3_2Branding Awards 2013.html"><img src="../assets/images/person_one.jpg" class="img-responsive" /></a>
        <h4>罗金斯，网络专家</h4>
        <p><a href="#">毕业于米协力根州立大学，主修信息工程，丰富的开发经验</a></p>
      </div>
      <div class="col-md-3">
        <a href="7_3_2Branding Awards 2013.html"><img src="../assets/images/person_two.jpg" class="img-responsive" /></a>
        <h4>罗金斯，网络专家</h4>
        <p><a href="#">毕业于米协力根州立大学，主修信息工程，丰富的开发经验</a></p>
      </div>
      <div class="col-md-3">
        <a href="7_3_2Branding Awards 2013.html"><img src="../assets/images/person_three.jpg" class="img-responsive" /></a>
        <h4>罗金斯，网络专家</h4>
        <p><a href="#">毕业于米协力根州立大学，主修信息工程，丰富的开发经验</a></p>
      </div>
      <div class="col-md-3">
        <a href="7_3_2Branding Awards 2013.html"><img src="../assets/images/person_four.jpg" class="img-responsive" /></a>
        <h4>罗金斯，网络专家</h4>
        <p><a href="#">毕业于米协力根州立大学，主修信息工程，丰富的开发经验</a></p>
      </div>
    </div>
    <h3 class="margin-btm">找到我们</h3>
    <div class="row address-field">
      <div class="col-md-6">
        <p>本初网络</p>
        <p>15686103270</p>
        <p>029-86479891</p>
        <p>admin@ibenchu.com</p>
        <div class="address">
          <p>中国·陕西省·西安市</p>
          <p>雁塔区高新二路陕西地建公寓楼2304</p>
        </div>
      </div>
      <div class="col-md-6 amap-wrapper">
        <el-amap :vid="'amap-vue'" :center="center" :zoom="zoom">
          <el-amap-marker v-for="marker in markers" :position="marker.position" :events="marker.events"> </el-amap-marker>
        </el-amap>
      </div>
    </div>
  </div>
</template>
<script>
  // import Vue from 'vue'

  export default {
    data () {
      return {
        zoom: 15,
        center: [108.9023906, 34.23954592],
        markers: [
          {
            position: [108.9023906, 34.23954592],
            events: {
              click: () => {
                alert('雁塔区高新二路陕西地建公寓楼2304')
              }
            }
          }
        ]
      }
    }
  }
</script>
