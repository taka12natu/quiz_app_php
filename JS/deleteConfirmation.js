function confirmDelete(id){
  if(!confirm('この問題を削除しますか？')){
    return false;
  }else if(id<8){
    alert('この問題は削除できません。')
    return false;
  }
 }