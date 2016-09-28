var MAXIMUM_TASKS = 6;
var config = {
  apiKey: "AIzaSyAPjJuJWsn9PnmTZaHwO0-Bj3HZllXLJ9A",
  authDomain: "projectmirror-c147e.firebaseapp.com",
  databaseURL: "https://projectmirror-c147e.firebaseio.com",
  storageBucket: "projectmirror-c147e.appspot.com",
  messagingSenderId: "728914482507"
};
firebase.initializeApp(config);

$("#Tasks .absolute_wrapper").ready(function(){
  var ref = firebase.database().ref().limitToLast(MAXIMUM_TASKS);
  ref.on("child_added",function(snapshot){
    addChild(snapshot.val());
  });
  ref.on("child_changed",function(snapshot){
    changeChild(snapshot.val());
  });
});

function addChild(jsonObj){
  console.log(jsonObj);
  var html = "";
  html = "<div class='task_card task_card_"+jsonObj.id+"'>"+setInnerHtml(jsonObj)+"</div></div>";
  var cards = $("#Tasks >.wrapper >.absolute_wrapper").find(".task_card");
  if(cards.length >= MAXIMUM_TASKS)
    $(cards[0]).remove();
  $("#Tasks >.wrapper >.absolute_wrapper").append(html);
}

function changeChild(jsonObj){
  var cards = $("#Tasks >.wrapper >.absolute_wrapper").find(".task_card");
  $(cards).each(function(){
    if($(this).hasClass("task_card_"+jsonObj.id)){
      $(this).html(setHtmlInner(jsonObj));
      return;
    }
  });
  addChild(jsonObj);
}

function setInnerHtml(jsonObj){
  var innerHtml = "";
  var margin = "0%";
  var iconSrc = "task_uncompleted.png";
  if(jsonObj.completed)
    iconSrc = "task_completed.png";

  innerHtml = innerHtml+"<div class='task_image wrapper'><img class='image' src='"+iconSrc+"'/></div><div class='text_panel'><div class='absolute_wrapper'"+
  "style='position: absolute;top: 50%;transform: translate(0%,-50%)'><div class='task_title'><p>"+jsonObj.title+
  ":</p></div><div class='task_description'><p>"+jsonObj.description+"</p></div></div></div>";
  return innerHtml;
}
