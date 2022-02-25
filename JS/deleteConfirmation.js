/* 最初に設定した7問は削除できないように設定 */
function confirmDelete(id){
  if(!confirm('この問題を削除しますか？')){
    return false;
  }else if(id<8){
    alert('この問題は削除できません。\n新規登録した問題は削除可能です。')
    return false;
  }
 }