// 問題形式を選択した時に実行
let createForm = document.getElementById('create_form');
createForm.addEventListener('change', valueChange);

// チェックボックス
let checkboxForm = document.getElementById('checkbox_form');
let checkText = checkboxForm.getElementsByClassName('checkbox_text');
let checkSelect = checkboxForm.getElementsByClassName('checkbox_select');

// ラジオボタン
let radioForm = document.getElementById('radio_form');
let radioText = radioForm.getElementsByClassName('radio_text');
let radioSelect = radioForm.getElementsByClassName('radio_select');

// 問題形式を選択した際に入力欄の表示を切り替え
function valueChange(event){
  let checkValue = createForm.elements['form_select'].value;
  if(checkValue == 'radio'){
    radioForm.style.display = "block";
    checkboxForm.style.display = "none";
    // 選択していない要素（チェックボックス）の値を消しておく
    for(let i=0; i < checkText.length; i++){
      checkText[i].value = '';
      checkSelect[i].checked = false;
    }
  }else if(checkValue == 'checkbox'){
    checkboxForm.style.display = "block";
    radioForm.style.display = "none";
    // 選択していない要素（ラジオボタン）の値を消しておく
    for(let i=0; i < radioText.length; i++){
      radioText[i].value = '';
      radioSelect[i].checked = false;
    }
  }
}