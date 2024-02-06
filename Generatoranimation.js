class Entry {
    constructor(count, type, name, data) {
      this.count = count;
      this.type = type;
      this.name = name;
      this.data = data;
    }
}
const entries = [];

let questionCount = 1;

function popup(event){
    let x = event.target.id; //get name of clicked element
    let panelname = "";

    switch(x) //determine the correct panel to toggle display for user
    {
        case "MPbutton":
            panelname = "MPpanel";
            break;
        case "CLbutton":
            panelname = "CLpanel";
            break;
        case "ERbutton":
            panelname = "ERpanel";
            break;
        case "DTbutton":
            panelname = "DTpanel";
            break;
        case "Tbutton":
            panelname = "Tpanel";
            break;
    }

    if (document.getElementById(panelname).style.display == "none") //if shown, hide. if hidden, show
    {
        document.getElementById(panelname).style.display = "block";
    }
    else
    {
        document.getElementById(panelname).style.display = "none";
    }
}


function updateMPDemo(event)
{
    let string = document.getElementById("MPoption").value;
    
    document.getElementById("MPcontainer").innerHTML += `<input type="radio">
    <label>${string}</label><br>
    `;
}

function updateCLDemo(event)
{
    let string = document.getElementById("CLoption").value;

    document.getElementById("CLcontainer").innerHTML += `<input type="checkbox">
    <label>${string}</label><br>
    `;
}


function updateTitle(event)
{
    let containername = "";
    let title = "";
    switch(event.target.id){
        case "MPtitleButton":
            containername = "MPTitleContainer";
            title = "MPtitle";
            break;
        case "CLtitleButton":
            containername = "CLTitleContainer";
            title = "CLtitle";
            break;
        case "ERtitleButton":
            containername = "ERTitleContainer";
            title = "ERtitle";
            break;
        case "DTtitleButton":
            containername = "DTTitleContainer";
            title = "DTtitle";
            break;
        case "TtitleButton":
            containername = "TTitleContainer";
            title = "Ttitle";
            break;
    }

    document.getElementById(containername).innerHTML = document.getElementById(title).value; 
}

function submitToTable(event)
{
    let type = "";
    let title = "";
    let data = "";
    let arr = [];
    let i = 0;
    let container = "";
    let contname = "";

    switch(event.target.id){
        case "MPsubmit":
            type = "Multiple Choice";
            contname = "MPcontainer";
            container = "MPTitleContainer";
            title = document.getElementById("MPTitleContainer").innerHTML; //assign title
            //parse generated MP table for values
            let str = document.getElementById("MPcontainer").innerHTML;
            let index = 0;
            do
            {
                index++;
                index = str.indexOf("<label>", index);
                if(index != -1)
                {
                    arr[i++] = str.substring(index+7, str.indexOf("</label",index)); //throw values here
                    data += arr[i-1] + ",";//str.substring(index+7, str.indexOf("</label",index));
                }
            }
            while(index !=-1);
            data = data.substring(0,data.length-1);//parse last comma off of data string
            break;
        case "CLsubmit":
                contname = "CLcontainer";
                container = "CLTitleContainer";
                type = "Check Boxes";
                title = document.getElementById("CLTitleContainer").innerHTML; //assign title
                //parse generated MP table for values
                let str1 = document.getElementById("CLcontainer").innerHTML;
                let index1 = 0;
                do
                {
                    index1++;
                    index1 = str1.indexOf("<label>", index1);
                    if(index1 != -1)
                    {
                        arr[i++] = str1.substring(index1+7, str1.indexOf("</label",index1)); //throw values here
                        data += arr[i-1] + ",";
                    }
                }
                while(index1 !=-1);
                data = data.substring(0,data.length-1);//parse last comma off of data string
                break;
        case "ERsubmit":
            container = "ERTitleContainer";
            type = "Extended Response";
            title = title = document.getElementById("ERTitleContainer").innerHTML; //assign title
            data = "N/A";
            break;
        
        case "DTsubmit":
            container = "DTTitleContainer";
            type = "Date";
            title = title = document.getElementById("DTTitleContainer").innerHTML; //assign title
            data = "N/A";
            break;
        case "Tsubmit":
            container = "TTitleContainer";
            type = "Time";
            title = title = document.getElementById("TTitleContainer").innerHTML; //assign title
            data = "N/A";
            break;

        default:
            break;
    }
    document.getElementById(container).innerHTML = "Default Question";
    if(contname != "")
    {
        document.getElementById(contname).innerHTML = "";
    }
    


    document.getElementById("surveyTable").innerHTML += `
        <td>${questionCount++}</td>
        <td>${type}</td>
        <td>${title}</td>
        <td>${data}</td>
            `;

    
    switch(type)
    {
        case "Multiple Choice":
            type= "MC";
            break;
        case "Check Boxes":
            type= "CB";
            break;
        case "Extended Response":
            type= "ER";
            break;
        case "Date":
            type= "D";
            break;
        case "Time":
            type= "T";
            break;

    }

    if(data == "N/A"){ data = "";}
    
    while(data.indexOf(",") != -1)//swap all ',' with '`'
    {
        data = data.replace(',','`');
    }

    entries[questionCount-2] = new Entry(questionCount-1,type, title,data );



}

function setFormInputs(){

    var input = document.createElement("input");

    input.setAttribute("type", "hidden");

    input.setAttribute("name", "questions");

    input.setAttribute("value", "");



    var input2 = document.createElement("input");

    input2.setAttribute("type", "hidden");

    input2.setAttribute("name", "maintitle");

    input2.setAttribute("value", "");




    document.getElementById("myForm").appendChild(input);
    document.getElementById("myForm").appendChild(input2);
}

function fillFormInputs(){
    let input = document.getElementById("myForm").elements["questions"];
    let str = "";


    if(document.getElementById("sTitle").value =="")
    {
        alert("Please Enter A title");
        return false;
    }

    entries.forEach(element => {
        str += element.count + '|';
        str += element.type + '|';
        str += element.name + '|';
        str += element.data + '|';
    });
    str = str.substring(0,str.length-1);//parse last '|' off of data string
    console.log(str);
    input.setAttribute("value", str);

    return true;

    
}

function updateOfficialTitle()
{
    currentval = document.getElementById("sTitle");
    let input = document.getElementById("myForm").elements["maintitle"];
    input.value = currentval.value;
    
}