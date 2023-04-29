$(document).ready(() => {
	//js starts
	var m = 1;
	var t = 1;
	var w = 1;
	var th = 1;
	var f = 1;
	var s = 1;
	var su = 1;
	var pretime1 = [];
	var pretime12 = [];
	var pretime2 = [];
	var pretime22 = [];
	var pretime3 = [];
	var pretime32 = [];
	var pretime4 = [];
	var pretime42 = [];
	var pretime5 = [];
	var pretime52 = [];
	var pretime6 = [];
	var pretime62 = [];
	var pretime7 = [];
	var pretime72 = [];
	//save_data starts
	$('#save_data').click(function() {
		pretime1 = [];
		pretime12 = [];
		pretime2 = [];
		pretime22 = [];
		pretime3 = [];
		pretime32 = [];
		pretime4 = [];
		pretime42 = [];
		pretime5 = [];
		pretime52 = [];
		pretime6 = [];
		pretime62 = [];
		pretime7 = [];
		pretime72 = [];
		m = 1;
		t = 1;
		w = 1;
		th = 1;
		f = 1;
		s = 1;
		su = 1;
		$(".message").html("");
	});
	// save_data ends
	const addSession = document.querySelectorAll(".addSession");
	const selectAll = document.querySelector("#selectall");
	let mondaySessions = document.querySelector(".mon-sessions");
	if(mondaySessions){
		let mondayAlerts = mondaySessions.querySelectorAll(".close");
		mondayAlerts.forEach((closeLink) => {
			closeLink.addEventListener("click", function () {
				if (selectAll.checked) {
					selectAll.checked = false;
				}
			});
		});
	}
	
	//for loop starts
	for (let btn of addSession) {
		// on click addSession starts
		btn.addEventListener("click", function (event) {
			// console.log("asdasd");
			$("#myModal2").modal('show');
			var flag1 = false;
			$("#hiddenInput").val("." + event.target.value);
			// save btn click starts
			$(".saveBtn").click(function () {
				//event.preventDefault();
				flag2 = false;
				let fromTime = $("#startingtime").val();
				let toTime = $("#endingtime").val();
				let errors = "";
				if (!fromTime.length || !toTime.length) {
					errors += "<p>Enter All Input Fields</p>";
				}
				fromTime = fromTime.replace(/\s/g, ":");
				toTime = toTime.replace(/\s/g, ":");
				fromTime = fromTime.split(":");
				toTime = toTime.split(":");
				let startTime = fromTime[0] + fromTime[1];
				let endTime = toTime[0] + toTime[1];
				startTime = parseInt(startTime);
				endTime = parseInt(endTime);
				if(fromTime[2] == "PM")
				{
					if(fromTime[0]==12)
						var sTime = startTime;
					else
						var sTime = startTime + 1200;
				}
				else
				{
					if(fromTime[0]==12)
						var sTime = startTime-1200;
					else
						var sTime = startTime;
				}
				if(toTime[2] == "PM")
				{
					if(toTime[0]==12)
						var eTime = endTime;
					else
						var eTime = endTime + 1200;
				}
				else
				{
					if(toTime[0]==12)
						var eTime = endTime-1200;
					else
						var eTime = endTime;
				}
				flag = false;
				if (fromTime[2] == "AM" && toTime[2] == "AM") {
					if(fromTime[0] == 12)
					{
						if(endTime - startTime >= -1000)
							flag = true;
					}
					else
					{
						if(endTime - startTime >= 200) {
							flag = true;
						}
					}
				}
				if (fromTime[2] == "PM" && toTime[2] == "PM") {
					if (eTime - sTime >= 200) {
						flag = true;
					}
				} 
				else {
					if (eTime - sTime >= 200) {
						flag = true;
					}
				}
				// alert("count "+m+" flag2 ="+flag2 +"   "+startTime+"  "+pretime[0]);
				if(event.target.value == "mon-sessions")
				{
					if(m<=1)
						flag2=true;
					else if(m >1 )
					{
						for(var i=0;i<pretime1.length;i++)
						{
							if(pretime12[i] <= sTime || pretime1[i] >= eTime)
								flag2 = true;
						 	else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				if(event.target.value == "tue-sessions")
				{
					if(t<=1)
						flag2=true;
					else if(t >1 )
					{
						for(var i=0;i<pretime2.length;i++)
						{
							if(pretime22[i] <= sTime || pretime2[i] >= eTime)
								flag2 = true;
							else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				if(event.target.value == "wed-sessions")
				{
					if(w<=1)
						flag2=true;
					else if(w >1 )
					{
						for(var i=0;i<pretime3.length;i++)
						{
							if(pretime32[i] <= sTime || pretime3[i] >= eTime)
								flag2 = true;
							else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				if(event.target.value == "thu-sessions")
				{
					if(th<=1)
						flag2=true;
					else if(th >1 )
					{
						for(var i=0;i<pretime4.length;i++)
						{
							if(pretime42[i] <= sTime || pretime4[i] >= eTime)
								flag2 = true;
							else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				if(event.target.value == "fri-sessions")
				{
					if(f<=1)
						flag2=true;
					else if(f >1 )
					{
						for(var i=0;i<pretime5.length;i++)
						{
							if(pretime52[i] <= sTime || pretime5[i] >= eTime)
								flag2 = true;
							else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				if(event.target.value == "sat-sessions")
				{
					if(s<=1)
						flag2=true;
					else if(s >1 )
					{
						for(var i=0;i<pretime6.length;i++)
						{
							if(pretime62[i] <= sTime || pretime6[i] >= eTime )
								flag2 = true;
							else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				if(event.target.value == "sun-sessions")
				{
					if(su<=1)
						flag2=true;
					else if(su >1 )
					{
						for(var i=0;i<pretime7.length;i++)
						{
							if(pretime72[i] <= sTime || pretime7[i] >= eTime )
								flag2 = true;
							else
							{
								flag2 = false;
								break;
							}
						}
					}
				}
				//alert("count "+m+" flag2 ="+flag2 +"   "+startTime+"  "+pretime[0]);
				if(!flag2)
				{
					errors +="<p>Your time spans are overlapping</p>";
				}
				if (!flag) 
				{
					errors += "<p>Difference between start time and end time must be greater than or equal to 2 hours</p>";
				}
				if (errors) {
					let message = `<div class='alert' id='alertmessageDiv'>${errors}</div>`;
					$(".message").html(message);
				}
				else {
					if (!flag1) {
						$(".message").html("");
						$("<div class='alert'></div>").append(`
							<a class=close data-dismiss=alert>&times</a>
							<p> 
								${fromTime[0]}:${fromTime[1]} ${fromTime[2]}-${toTime[0]}:${toTime[1]} ${toTime[2]}
							</p>
						`).appendTo($("#hiddenInput").val());
						$("#myModal2").modal("hide");
						flag1 = true;
						if (selectAll.checked) {
							selectAll.checked = false;
						}
						if(event.target.value == "mon-sessions")
						{
							m++;
							pretime1.push(sTime);
							pretime12.push(eTime);
						}
						if(event.target.value == "tue-sessions")
						{
							t++;
							pretime2.push(sTime);
							pretime22.push(eTime);
						}						                    
						if(event.target.value == "wed-sessions")
						{
							w++;
							pretime3.push(sTime);
							pretime32.push(eTime);
						}
						if(event.target.value == "thu-sessions")
						{
							th++;
							pretime4.push(sTime);
							pretime42.push(eTime);
						}
						if(event.target.value == "fri-sessions")
						{
							f++;
							pretime5.push(sTime);
							pretime52.push(eTime);
						}
						if(event.target.value == "sat-sessions")
						{
							s++;
							pretime6.push(sTime);
							pretime62.push(eTime);
						}
						if(event.target.value == "sun-sessions")
						{
							su++;
							pretime7.push(sTime);
							pretime72.push(eTime);
						}
					}
				}
			});
			//save btn ends
			//close starts
			$(".close").on("click",function() {
				$(".message").html("");
				pretime1 = [];
				pretime12 = [];
				pretime2 = [];
				pretime22 = [];
				pretime3 = [];
				pretime32 = [];
				pretime4 = [];
				pretime42 = [];
				pretime5 = [];
				pretime52 = [];
				pretime6 = [];
				pretime62 = [];
				pretime7 = [];
				pretime72 = [];
				m = 1;
				t = 1;
				w = 1;
				th = 1;
				f = 1;
				s = 1;
				su = 1;
			});
			// close ends;
		});
	}
	//for loop ends
	//select all same time starts
	selectAll.addEventListener("click", () => {
		let dataArray = $(".day-session").each(() => {
			$(".day-session").html();
		});
		if (selectAll.checked) {
			$(".day-session").empty();
			let data = $(".mon-sessions").html();
			$(".day-session").html(data);
		}
	});
	//select all same time ends;
});