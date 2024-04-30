$(document).ready(function(){

  const quoteDisplayElement = document.getElementById('quoteDisplay')
  const quoteInputElement = document.getElementById('quoteInput')
  const timerElement = document.getElementById('timer')
  let countdownMsgInterval
  let isTimed

  $("#start-btn, #again-btn").click(async function(){
    var easy = $("#easyCheckBox").is(":checked");
    var medium = $("#mediumCheckBox").is(":checked"); 
    var hard = $("#hardCheckBox").is(":checked");

    var levelOne = $("#levelOneCheckBox").is(":checked");
    var levelTwo = $("#levelTwoCheckBox").is(":checked");
    var levelThree = $("#levelThreeCheckBox").is(":checked");
    var levelFour = $("#levelFourCheckBox").is(":checked");
    var levelFive = $("#levelFiveCheckBox").is(":checked");

    var difficultyBoxes = [easy, medium, hard];
    var levelBoxes = [levelOne, levelTwo, levelThree, levelFour, levelFive];

    var atLeastOneDifficultySelected = false;
    var atLeastOneLevelSelected = false;
    for (var i = 0; i < difficultyBoxes.length; i++) {
      if(difficultyBoxes[i]){
        atLeastOneDifficultySelected = true;
        break;
      }
    }
    for (var i = 0; i < levelBoxes.length; i++) {
      if(levelBoxes[i]){
        atLeastOneLevelSelected = true;
        break;
      }
    }

    if(atLeastOneDifficultySelected && atLeastOneLevelSelected){
      $(".no-selections").css("display", "none");
      var doesQuoteExist = await renderNewQuote();
      if(!doesQuoteExist){
        $(".no-quotes-avail").css("display", "block");
      } else {
        $(".no-quotes-avail").css("display", "none");
        $(".pregame").hide();
        $(".endgame").hide();
        $("nav").hide();
        $(".game").css("display", "flex");
        if ($("#timed").prop("checked")){
          timed = true;
          timerElement.innerText = "Ready.";
          var countdown = 2;
          doCountdown(2);
          countdownMsgInterval = setInterval(() => {
            doCountdown(--countdown)
          }, 1500);
        } else {
          timed = false;
          timerElement.innerText = "";
          $('#quoteInput').prop('readonly', false);
          $('#quoteInput').focus();
        }
      }
    } else {
      $(".no-selections").css("display", "block");
      $(".no-quotes-avail").css("display", "none");
    }
  });

  $("#home-btn").click(function(){
    $(".pregame").show();
    $(".endgame").hide();
    $("nav").show();
});

  $('#quoteInput').bind("paste",function(e) {
    e.preventDefault();
  });

  function doCountdown(countdown){
    switch(countdown) {
      case 2:
        timerElement.innerText = "Ready.";
        countdown--
        break;
      case 1:
        timerElement.innerText = "Set.";
        countdown--
        break;
      case 0:
        startTimer()
        $('#quoteInput').prop('readonly', false);
        $('#quoteInput').focus();
        clearInterval(countdownMsgInterval);
        break;
    }
  }

  quoteInputElement.addEventListener('input', () => {
    const arrayQuote = quoteDisplayElement.querySelectorAll('span')
    const arrayValue = quoteInputElement.value.split('')

    let correct = true
    arrayQuote.forEach((characterSpan, index) => {
      const character = arrayValue[index]
      if (character == null) {
        characterSpan.classList.remove('correct')
        characterSpan.classList.remove('incorrect')
        correct = false
      } else if (character === characterSpan.innerText) {
        characterSpan.classList.add('correct')
        characterSpan.classList.remove('incorrect')
      } else {
        characterSpan.classList.remove('correct')
        characterSpan.classList.add('incorrect')
        correct = false
      }
    })

    if (correct){
      if(timed){
        var endTime = getTimerTimeExactString();
        clearInterval(timerInterval);
      }
      $(".game").hide();
      $(".endgame").css("display", "flex");

      $("#results-pic").attr("src", "images/finishFlag.png");
      $("#personal-record").css("display", "none");
      $("#leaderboard-score").css("display", "none");

      $('#quoteInput').prop('readonly', true);

      if(timed){
        var quoteId;
        $.ajax({
          url: "database_scripts/get_quoteId.php",
          type: 'get',
          dataType: 'text',
          async: false,
          data: {
            quote: quote
          },
          success: function(returnData) {
            quoteId = returnData;
          } 
        });
  
        var wpm;
        $.ajax({
          url: "database_scripts/get_wpm.php",
          type: 'get',
          dataType: 'text',
          async: false,
          data: {
            quoteId: quoteId,
            timeTaken: endTime
          },
          success: function(returnData) {
            wpm = parseFloat(returnData);
          } 
        });
  
        $("#results-timeSpent").text("Time Spent: " + endTime);
        $("#results-wpm").text("Words/Minute: " + wpm);
  
        var personalBest;
        $.ajax({
          url: "database_scripts/checkPersonalBest.php",
          type: 'get',
          dataType: 'text',
          async: false,
          success: function(returnData) {
            personalBest = parseFloat(returnData);
          } 
        });
  
        if(wpm > personalBest){
          $("#personal-record").css("display", "block");
          $("#results-pic").attr("src", "images/medal.png");
        }
        
        var bottomOfLeaderboardScore;
        $.ajax({
          url: "database_scripts/checkLeaderboard.php",
          type: 'get',
          dataType: 'text',
          async: false,
          success: function(returnData) {
            bottomOfLeaderboardScore = parseFloat(returnData);
          } 
        });
  
        if(wpm > bottomOfLeaderboardScore){
          $("#leaderboard-score").css("display", "block");
          $("#results-pic").attr("src", "images/trophy.png");
        }
  
        $.post("database_scripts/post_submission.php", {
          quoteId : quoteId,
          timeTaken : endTime,
          wpm: wpm
        }); 
      }

    }
  })

  function getRandomQuote() {
    var easy = $("#easyCheckBox").is(":checked") ? "1" : "0";
    var medium = $("#mediumCheckBox").is(":checked") ? "1" : "0"; 
    var hard = $("#hardCheckBox").is(":checked") ? "1" : "0";

    var levelOne = $("#levelOneCheckBox").is(":checked") ? "1" : "0";
    var levelTwo = $("#levelTwoCheckBox").is(":checked") ? "1" : "0";
    var levelThree = $("#levelThreeCheckBox").is(":checked") ? "1" : "0";
    var levelFour = $("#levelFourCheckBox").is(":checked") ? "1" : "0";
    var levelFive = $("#levelFiveCheckBox").is(":checked") ? "1" : "0";
    
    var returnObj;
    $.ajax({
      url: "database_scripts/get_quote.php",
      type: 'get',
      data: {
        easy: easy,
        medium: medium,
        hard: hard,
        levelOne: levelOne,
        levelTwo: levelTwo,
        levelThree: levelThree,
        levelFour: levelFour,
        levelFive: levelFive
      },
      dataType: 'json',
      async: false,
      success: function(returnData) {
        returnObj = {
          quoteExists: returnData.quoteExists,
          quoteIfExists: returnData.quoteIfExists
        };
      } 
    });
    return returnObj;
  }

  let quote
  async function renderNewQuote() {
    quoteObj = await getRandomQuote()
    quoteExists = quoteObj.quoteExists;
    if(quoteExists){
      quote = quoteObj.quoteIfExists;
      quoteDisplayElement.innerHTML = ''
      quote.split('').forEach(character => {
        const characterSpan = document.createElement('span')
        characterSpan.innerText = character
        quoteDisplayElement.appendChild(characterSpan)
      })
      quoteInputElement.value = null
      return true;
    } else {
      return false;
    }
  }

  let startTime
  let timerInterval
  function startTimer() {
    timerElement.innerText = "Go!"
    startTime = new Date()
    timerInterval = setInterval(() => {
      var timerText = getTimerTime()
      timerElement.innerText = timerText
    }, 1000)
  }

  function getTimerTime() {
    return Math.floor((new Date() - startTime) / 1000)
  }

  const formatter = new Intl.NumberFormat('en-US', {
    minimumFractionDigits: 3,      
    maximumFractionDigits: 3,
  });

  function getTimerTimeExactString() {
    return formatter.format((new Date() - startTime) / 1000);
  }
})