  <style>
    *{
      margin:0;
      padding:0;
      box-sizing: border-box;
    }
    .wrap{
      width:500px;
      height: 580px;
      margin:auto;
      background:brown;
      padding:50px;
      position: relative;
    }
    .card{
	  /*vertical-align: middle;*/
	  font-size:90px;
      width: 100px;
      height: 120px;
      border:1px solid skyblue;
      float:left;
      text-align: center;
      background: wheat;
    }
    #wall{
      width: 400px;
      height: 480px;
      position:absolute;
      left:50px;
      top:50px;
      display: none;
    }
  
  </style>


 <div class="wrap">
  <div class="card">1</div>
  <div class="card">2</div>
  <div class="card">3</div>
  <div class="card">4</div>
  <div class="card">5</div>
  <div class="card">6</div>
  <div class="card">7</div>
  <div class="card">8</div>
  <div class="card">1</div>
  <div class="card">2</div>
  <div class="card">3</div>
  <div class="card">4</div>
  <div class="card">5</div>
  <div class="card">6</div>
  <div class="card">7</div>
  <div class="card">8</div>
    <div id="wall"></div>
 </div>
 
<script>
/*
1.建立基本畫面元件
2.建立點擊翻面的方法
3.限制連續點擊以避免錯誤發生

*/
gap=1;
step=1;
running=0;
flipcard=0;

tmpCardVal=[0,0];
tmpCardIdx=[0,0]

function flip(flipIdx){
	if (running==0){
		running=1;
		timer = setInterval(function(){
			if (step==1){
				if (gap>0){
					gap=gap-0.02;
					cards[flipIdx].style.transform="scaleX("+gap+")";
				}else{
					step=2;
					cards[flipIdx].style.background="#fff";
					cards[flipIdx].innerHTML=num[flipIdx];
				}
			}else{
				if (gap<1){
					cards[flipIdx].style.transform="scaleX("+gap+")";
					gap=gap+0.02;
				}else{
					clearInterval(timer);
					cards[flipIdx].style.transform="scaleX(1)";

					if (tmpCardVal[1]!=0 && tmpCardVal[0]!=0){
						if (tmpCardVal[1]==tmpCardVal[0]){
							flipcard=0;
							tmpCardVal[0]=0;
							tmpCardVal[1]=0;
						}else{
							setTimeout(function(){
								cards[tmpCardIdx[0]].innerHTML="";
								cards[tmpCardIdx[1]].innerHTML="";
								cards[tmpCardIdx[0]].style.background="wheat";
								cards[tmpCardIdx[1]].style.background="wheat";

								flipcard=0;
								tmpCardVal[0]=0;
								tmpCardVal[1]=0;
							},2000);
						}
					}
					gap=1;
					step=1;
					running=0;
				}
			}
		},10);
	}
}
function swap(swapIdx){
	if (running==0){
		if (cards[swapIdx].innerHTML==""){
			if (flipcard<2){
				tmpCardIdx[flipcard]=swapIdx;
				tmpCardVal[flipcard]=num[swapIdx];

				flipcard=flipcard+1;
				flip(swapIdx);
			}
		}
	}
}

let num=[1,2,3,4,5,6,7,8,1,2,3,4,5,6,7,8];
let cards=document.getElementsByClassName('card');
for (i=0;i<cards.length;i++){
	cards[i].innerHTML="";
	cards[i].onclick=function(){
		idx= Array.prototype.indexOf.call(cards, this);
		//this.innerHTML=num[idx];
		swap(idx);
	}
}




</script>