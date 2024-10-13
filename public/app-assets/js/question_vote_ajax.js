let question_like_buttons = document.querySelectorAll(".question_like_vote");
let question_dislike_buttons = document.querySelectorAll(".question_dislike_vote");

question_like_buttons.forEach(button => {
  button.addEventListener("click", function() {
    questionLikeVote(button);
  });
});

question_dislike_buttons.forEach(button => {
  button.addEventListener("click", function() {
    questionDislikeVote(button);
  });
});


function questionLikeVote(button) {
  let value = button.value;

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.status === 'error') {
        alert(response.message);  // Show alert if the user is not logged in
      } else {
        console.log(response.message);  // Handle success case
        location.reload();
      }
    }
  };

  xhr.open(
    "GET",
    `http://localhost/php-stackoverflow/question/vote/${value}`,
    true
  );

  xhr.send();
}


function questionDislikeVote(button)
{
  let value = button.value;

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.status === 'error') {
        alert(response.message);  // Show alert if the user is not logged in
      } else {
        console.log(response.message);  // Handle success case
        location.reload();
      }
    }
  };

  xhr.open(
    "GET",
    `http://localhost/php-stackoverflow/question/vote/${value}`,
    true
  );

  xhr.send();
}

