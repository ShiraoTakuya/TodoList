function main(){
    startup();   
}

function startup(){
    initial_data();
    view_data(recv_data());
    
    document.getElementById("form").addEventListener("submit", function(event){
        event.preventDefault();
        submit_inputbox();
    })
}

function initial_data(){
    let request = new XMLHttpRequest();
    request.open('GET', 'initial_data.php', false);
    request.send();
}
function recv_data(){
    let request = new XMLHttpRequest();
    request.open('GET', 'recv_data.php', false);
    request.send();
    return JSON.parse(request.responseText);
}
function view_data(data){
    document.getElementById("lists").innerHTML = '';
    add_ul(data);
    add_list(data);
}

function send_data(id,parentid,elementtype,string,finish,hide){
    let xhr = new XMLHttpRequest()
    xhr.open('GET', 'send_data.php?id='+id+'&parentid='+parentid+'&elementtype='+elementtype+'&string='+string+'&finish='+finish+'&hide='+hide, false);
    xhr.send();
}


function add_ul(data){
    data.slice().reverse().forEach(row => {
        if(row["elementtype"] != "ul"){
            return;
        }
        const lists = document.getElementById("lists");

        var div = document.createElement("div");
        div.setAttribute("id", row["id"]);
        lists.appendChild(div);

        var list1 = document.createElement("input");
        list1.setAttribute("type", "checkbox");
        list1.setAttribute("id", "check"+row["string"]);
        list1.setAttribute("onclick", 'clickBtn("'+row["id"]+'")');
        div.appendChild(list1);
        
        var label1 = document.createElement("label");
        label1.setAttribute("for", "label"+row["string"]);
        label1.textContent = row["string"];
        div.appendChild(label1);

        var ul1 = document.createElement("ul");
        if(row["hide"] == "0"){
            ul1.setAttribute("style", "display: block;");
            list1.checked = true;
        }else{
            ul1.setAttribute("style", "display: none;");
        }
        div.appendChild(ul1);
        div.appendChild(document.createElement("br"));
    });
}
function add_list(data){
    data.forEach(row => {
        if(row["elementtype"] != "li"){
            return;
        }

        const li = document.createElement("li");
        li.innerText = row["string"];
        li.classList.add("list");
        li.setAttribute("id", row["id"]);

        if(row["finish"] == 1){
            li.classList.toggle("line-through");
        }

        li.addEventListener("click", function(event){
            li1 = event.target;
            send_data(li1.id, li1.parentNode.parentNode.id, "li", li1.innerHTML, String((event.target.classList.contains("line-through"))?0:1), "0");
            view_data(recv_data());
        });
        
        const div = document.getElementById(row["parentid"]);
        const ul = div.getElementsByTagName("ul")[0];
        ul.appendChild(li);
    });
}

function submit_inputbox(){
    const input = document.getElementById("input");
    let uls = document.querySelectorAll('ul[style="display: block;"]');
    let ul_flag = true;
    uls.forEach((ul,i) => {
        send_data("null", ul.parentNode.id, "li", input.value, "0", "0");
        view_data(recv_data());
        ul_flag = false;
    });
    
    if(ul_flag){
        send_data("null", "null", "ul", input.value, "0", "0");
        view_data(recv_data());
    }

    input.value = "";
}

function clickBtn(id){
    const div = document.getElementById(id);
    const ul = div.getElementsByTagName("ul")[0];
    const label = div.getElementsByTagName("label")[0];
    if(ul.style.display == "block"){
        ul.style.display = "none";
        send_data(div["id"], "null", "ul", label.innerHTML, "0", "1");
    }else{
        ul.style.display = "block";
        send_data(div["id"], "null", "ul", label.innerHTML, "0", "0");
    }
    view_data(recv_data());
}

main();
