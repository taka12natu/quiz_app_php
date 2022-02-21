/* create.php */

// チェックボックス
let checkboxForm = document.getElementById('checkbox_form');
let checkText = checkboxForm.getElementsByClassName('checkbox_text');
let checkSelect = checkboxForm.getElementsByClassName('checkbox_select');

// ラジオボタン
let radioForm = document.getElementById('radio_form');
let radioText = radioForm.getElementsByClassName('radio_text');
let radioSelect = radioForm.getElementsByClassName('radio_select');

// テキストボックス
let textboxForm = document.getElementById('textbox_form');
let textboxText = document.getElementById('textbox_text');

// 問題形式を選択した時に実行
let createForm = document.getElementById('create_form');
createForm.addEventListener('change', valueChange);

// 問題形式を選択した際に入力欄の表示を切り替え
function valueChange(event){
  let checkValue = createForm.elements['form_select'].value;
  if(checkValue == 'radio'){
    radioForm.style.display = "block";
    checkboxForm.style.display = "none";
    textboxForm.style.display = "none";
    // 選択していない要素の値を消しておく
    textboxText.value = '';
    for(let i=0; i < checkText.length; i++){
      checkText[i].value = '';
      checkSelect[i].checked = false;
    }
  }else if(checkValue == 'checkbox'){
    checkboxForm.style.display = "block";
    radioForm.style.display = "none";
    textboxForm.style.display = "none";
    // 選択していない要素の値を消しておく
    textboxText.value = '';
    for(let i=0; i < radioText.length; i++){
      radioText[i].value = '';
      radioSelect[i].checked = false;
    }
  }else if(checkValue == 'textbox'){
    textboxForm.style.display = "block";
    radioForm.style.display = "none";
    checkboxForm.style.display = "none";
    // 選択していない要素の値を消しておく
    for(let i=0; i < radioText.length; i++){
      radioText[i].value = '';
      radioSelect[i].checked = false;
    }
    for(let i=0; i < checkText.length; i++){
      checkText[i].value = '';
      checkSelect[i].checked = false;
    }
  }
}
/* 回答形式を増やすことを考えると登録を押したときに処理走らせた方が良いかも？
　　それかphpの方の登録処理のロジックを変更するか　要検討 
*/

let questionBox = document.getElementsByClassName('question_box')[0];
let createButton = document.getElementById('create_do');
let typeSelect = document.getElementsByName('form_select');
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
  }
  /* 問題形式のラジオボタン未選択時のエラー処理 */
  let flg = false;
  for(i=0; i<typeSelect.length; i++){
    if(typeSelect[i].checked == true){
      flg = true;
    }
  } 
  if(!flg){
    let errTag = errorText('※選択してください');
    let typeLabel = document.getElementById('type_label');
    typeLabel.appendChild(errTag);
    return false; 
  }else{
    /* 各問題形式の入力チェック */
    flg = false;
    let checkValue = createForm.elements['form_select'].value;
    switch(checkValue){
      case 'radio':
        for(let i=0; i < radioText.length; i++){
          if(radioText[i].value == ''){
            let errTag = errorText('※入力してください');
            createForm.insertBefore(errTag,createButton);
            return false;
          }else if(radioText[i].value.length > 30){
            let errTag = errorText('※30字以内で入力してください');
            createForm.insertBefore(errTag,createButton);
            return false;
          }
          if(radioSelect[i].checked == true){
            flg = true;
          }
        }
        break;
      case 'checkbox':
        for(let i=0; i < checkText.length; i++){
          if(checkText[i].value == ''){
            let errTag = errorText('※入力してください');
            createForm.insertBefore(errTag,createButton);
            return false;
          }else if(checkText[i].value.length > 20){
            let errTag = errorText('※50字以内で入力してください');
            createForm.insertBefore(errTag,createButton);
            return false;
          }
          if(checkSelect[i].checked == true){
            flg = true;
          }
        }
        break;
      case 'textbox':
        if(textboxText.value == ""){
          let errTag = errorText('※入力してください');
          createForm.insertBefore(errTag,createButton);
          textboxText.classList.add("error_display");
          return false;     
        }else if(textboxText.value.length > 30){
          let errTag = errorText('※30字以内で入力してください');
          createForm.insertBefore(errTag,createButton);
          textboxText.classList.add("error_display");
          return false;     
        }else{
          flg = true;
        }
        break;
    }
    /* 正解フラグが未選択の場合のエラー表示 */
    if(!flg){
      let errTag = errorText('※選択してください');
      createForm.insertBefore(errTag,createButton);
      return false; 
    }else{
      document.create_form.submit();
    }
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