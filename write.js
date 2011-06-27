(function($){

  var delay = 3000;

  /* Draw a pie chart using Google chart API */
  var drawChart = function(sentiments) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Sentiment');
    data.addColumn('number', 'score');
    data.addRows(sentiments.length);
    
    for(var i = 0; i < sentiments.length; i++) {
      data.setValue(i, 0, sentiments[i].sentiment);
      data.setValue(i, 1, sentiments[i].score);
    };
          
    var chart = new google.visualization.PieChart(document.getElementById('post_sentiment_chart'));
    chart.draw(data, {width: 650, height: 500, title: 'Sentiments', is3D: true});
  };
  
  
  $(document).ready( function() {
    var lastContent;
    
    
    var checkSentiment = function() {
      var content;
      /* make sure tinyMCE is initalized properly */
      if(typeof(tinyMCE) != 'undefined') {
        if(!tinyMCE.activeEditor) {
          setTimeout(checkSentiment, 500);
          return;
        };
        content = tinyMCE.activeEditor.getContent();
      } else {
        /* for user who disables visual editor */
        content = $('#content').val();
      };
      
      /* strip out HTML tags since EffectCheck doesn't like HTML */
      content = content.replace(/<.+?>/g, '');
      
      /* don't check if don't need to */
      if(content.length == 0) return;
      if(content == lastContent) return;
      lastContent = content;

      /* Check with EffectCheck */
      $.ajax({ url: ajaxurl, type: 'POST', data: { action: 'submit_to_effectcheck', content: content }, dataType: "json",
        success: function(response){
          var sentiments = [];
          $.each(response, function(k,sentiment) {
            if(sentiment.ChartLevel) sentiments.push({score: sentiment.ChartLevel, sentiment: k});
          });

          /* sort for top sentiments in reverse order */
          sentiments.sort(function(a,b){ return a.score > b.score ? -1 : a.score < b.score ? 1 : 0; });
          
          drawChart(sentiments);
          
          /* Grab the top 3 sentiments */
          var sentimentsToDisplay = [];
          for(var i = 0; i < 3; i++) {
            if(sentiments[i].score > 0) {
              sentimentsToDisplay.push( sentiments[i].sentiment );
            };
          };
          
          $('#post_sentiment').html("Your post's top sentiments are: <span style='font-size:24px'>" + sentimentsToDisplay.join(', ') + "</span></b>");
          setTimeout(checkSentiment, delay);
        }
      });
      
    };
    
    checkSentiment();
  });
})(jQuery);