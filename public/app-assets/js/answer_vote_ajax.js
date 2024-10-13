let like_buttons = document.querySelectorAll(".answer_like_vote");
let dislike_buttons = document.querySelectorAll(".answer_dislike_vote");

like_buttons.forEach(button => {
  button.addEventListener("click", function() {
    likeVote(button);
  });
});

dislike_buttons.forEach(button => {
  button.addEventListener("click", function() {
    dislikeVote(button);
  });
});


function likeVote(button) {
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
    `http://localhost/php-stackoverflow/answer/vote/${value}`,
    true
  );

  xhr.send();
}


function dislikeVote(button)
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
    `http://localhost/php-stackoverflow/answer/vote/${value}`,
    true
  );

  xhr.send();
}







