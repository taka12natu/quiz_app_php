let submitButton = document.getElementById('send');
submitButton.addEventListener('click', function() {
  document.answer_box.submit();
});

function changeColor(obj){
  let select_label = obj.parentElement;
  let labels = document.getElementsByClassName('label');
  if(obj.type == "radio"){
    /* 選択済みのラベルを未選択に戻すため、全ラベルを対象に処理 */
    for(i=0;i<labels.length;i++){
      labels[i].classList.remove('clicked_color');
    } 
    /* 選択したラベルの要素を取得してクラス付与 */
    select_label.classList.add('clicked_color');
    /* チェックボックスの時は複数選択できるようにする */
  }else if(obj.type == "checkbox"){
    if(obj.checked){
      select_label.classList.add('clicked_color');
    }else{
      select_label.classList.remove('clicked_color');
    }
  }
}

