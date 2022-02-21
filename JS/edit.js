/* edit.php */

// チェックボックス・ラジオボタン
let choiceBox = document.getElementsByClassName('choice_box');
let choiceSelect = document.getElementsByClassName('choice_select');

// テキストボックス
let textboxText = document.getElementById('textbox_text');

let questionBox = document.getElementsByClassName('question_box')[0];

let editForm = document.getElementById('edit_form');
let editButton = document.getElementById('edit_do');

/* 入力チェック */
function confirmValue(){

  /* 問題文が未入力の場合のエラー処理 */
  if(questionBox.value == ""){
    let errTag = errorText('※入力してください');
    let questionLabel = document.getElementById('question_label');
    questionLabel.appendChild(errTag);
    questionBox.classList.add("error_display");
    return false;
  }else if(questionBox.value.length > 50){
    let errTag = errorText('※50字以内で入力してください');
    let questionLabel = document.getElementById('question_label');
    questionLabel.appendChild(errTag);
    questionBox.classList.add("error_display");
    return false;
  }else{
    /* 各問題形式の入力チェック */
    flg = false;
    if(choiceBox.length>0){
      for(let i=0; i < choiceBox.length; i++){
        if(choiceBox[i].value == ""){
          let errTag = errorText('※入力してください');
          editForm.insertBefore(errTag,editButton);
          return false;
        }else if(choiceBox[i].value.length > 30){
          let errTag = errorText('※30字以内で入力してください');
          editForm.insertBefore(errTag,editButton);         
        }
        if(choiceSelect[i].checked == true){
          flg = true;
        }
      }
    }else{
      if(textboxText.value == ""){
        let errTag = errorText('※入力してください');
        editForm.insertBefore(errTag,editButton);
        textboxText.classList.add("error_display");
        return false;     
      }else if(textboxText.value.length > 30){
        let errTag = errorText('※30字以内で入力してください');
        editForm.insertBefore(errTag,editButton);
        textboxText.classList.add("error_display");
        return false;     
      }else{
        flg = true;
      }
    }
  }
    /* 正解フラグが未選択の場合のエラー表示 */
    if(!flg){
      let errTag = errorText('※選択してください');
      editForm.insertBefore(errTag,editButton);
      return false; 
    }else{
      document.edit_form.submit();
    }
};

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