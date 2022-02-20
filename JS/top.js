let startButton = document.getElementById('start');
let nameBox = document.getElementById('name_box');
let inputName = document.getElementById('input_name');
let radioBox = document.getElementsByClassName("radio_box")[0];
let radioBtn = document.start_form.question_number;
let flg = 0;
startButton.addEventListener('click', function(e) {
  /* 問題数選択のラジオボタンが選択されているか判定 */
  for(i=0; i<radioBtn.length; i++){
    if(radioBtn[i].checked == true){
      flg = 1;
    }
  }
  /* ニックネームが未入力の場合のエラー処理 */
  if(inputName.value == ""){
    let errTag = errorText('※入力してください');
    nameBox.appendChild(errTag);
    inputName.classList.add("error_display")
    return false;
  }else if(inputName.value.length > 10){
    let errTag = errorText('※10字以内で入力してください');
    nameBox.appendChild(errTag);
    inputName.classList.add("error_display")
    return false;
    /* ラジオボタン未選択時のエラー処理 */
  }else if(flg == 0){
    let errTag = errorText('※選択してください');
    radioBox.appendChild(errTag);
    return false;
  }else{
    document.start_form.submit();
  }
});
/* エラーメッセージ表示用のspanタグを作成 */
function errorText(msg){
  let span = document.createElement("span");
  let addText = document.createTextNode(msg);
  span.appendChild(addText);
  span.setAttribute("class", "error_text");
  return span;
}
/* 入力されたらエラーメッセージを削除 */
function check(obj){
  if(obj.classList.contains("error_display") == true){
    obj.classList.remove("error_display");
  }
  if(document.getElementsByClassName("error_text")[0]){
    document.getElementsByClassName("error_text")[0].remove();
   }
};