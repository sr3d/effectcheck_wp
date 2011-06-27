<!-- inject the sentiments here -->
<div id="effectcheck_wp_wrapper">
  <ul id="effectcheck_wp">
    <li>
      <div id="post_sentiment">
        Your Post's Sentiment will be updated here.
      </div><!-- #post_sentiment -->
      
      <div id="post_sentiment_chart"></div>
      
    </li>
  </ul>
  
  <div style="float: right;">
    Powered By <a href="http://effectcheck.com"><img align="middle" src="<?= plugins_url('logo.png', __FILE__) ?>"/></a>
  </div>
  <div style="clear:both"></div>
  
</div>
<script><?php include 'write.js' ?></script>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("visualization", "1", {packages:["corechart"]});</script>