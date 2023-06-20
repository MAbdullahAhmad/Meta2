let in_progress = false;
window.curr = 0;
window.loaded = false;

let add_node = id => {
  window.elems.parent.value = id;
  window.elems.node.checked  = true;
  window.elems.label.focus();
};

let neg_id = 0;
let add = keep => {
  if(window.pause) return alert("Paused!");
  let
    parent = window.elems.parent.value,
    label = window.elems.label.value,
    content = window.elems.content.value ?? ''
  ;

  if(!label) return;

  if(!parent){
    alert("Error E34234!");
    return;
  }

  // Add Node To Parent's Shelve
  let new_node = {
    id: --neg_id,
    label: label,
    children: [],
  };

  document.querySelector(`[shelve="${parent}"]`).append(
    make_node(new_node)
  );

  let parent_node = document.querySelector(`[node="${parent}"]`);
  if(parent_node){
    let pc = JSON.parse(parent_node.getAttribute('children')) ?? [[]];
    pc.push([new_node.id, label]);
    parent_node.setAttribute('children', JSON.stringify(pc));
  }

  // Reset Inputs
  window.elems.label.value =
  window.elems.content.value = '';

  // Close Modal or focus label
  if(!keep) window.elems.node.checked = false;
  else window.elems.label.focus();

  $.ajax({
    url: `/node`,
    method: 'POST',
    data: {
      parent,
      label,
      content,
      _token: window.token,
    },
    success: r => {
      if(typeof r != "object")
        r = JSON.parse(r) ?? {};

      if(r.success && r.id){
        // Itself
        let node = document.querySelector(`[node="${new_node.id}"]`);
        if(!node) return;

        node.setAttribute('node', r.id);
        node.onmouseover = () => preview(r.id);
        node.onclick = () => load(r.id);
        node.classList.remove('dull');

        // if(window.elems.curr.innerText < 0)
        if(window.curr < 0){
          window.elems.curr.innerText = window.curr = r.id;
        }

        // In Children of Parent Node
        if(parent_node){
          let new_children = [[]];
          let children = JSON.parse(parent_node.getAttribute("children") ?? [[]]);
          for(let i=1; i<children.length; i++){
            new_children.push(
              children[i] == new_node.id ? r.id : children[i]
            );
          }
          parent_node.setAttribute('children', JSON.stringify(new_children));
        }
      }
    },
    error: () => {
      alert("Please Check Your Internet Connection!");
      in_progress = false;
    },
  });
};

let make_node = node => {
  let elem = document.createElement('div');
  elem.classList.add('node');
  if(!node.active) elem.classList.add('dull');
  elem.setAttribute('children', JSON.stringify([[], ...node.children]));
  elem.setAttribute('node', node.id);
  elem.onmouseover = () => preview(node.id);
  elem.onclick = () => load(node.id);
  elem.innerText = node.label;

  return elem;
};

// // @debug
// setTimeout(() => {
//   for(let n of [
//     {active: true, id: 1, label: 'Fruits', children: [[5, 'Apple'], [6, 'Banana']] },
//     {active: true, id: 2, label: 'Time Table', children: [[7, 'New'], [8, 'Old']] },
//     {active: true, id: 3, label: 'Another Thing', children: [] },
    
//   ]) document.querySelector(`[shelve="0"]`).append(
//     make_node(n)
//   );
// }, 200);

// Hover: Preview Shelve
let preview = node => {
  if(window.pause) return;

  if(!document.querySelector(`[node="${node}"]:not(.preview)`))
  return;

  // Active
  window.curr = node;
  if(window.elems.curr.classList.contains('d-none'))
    window.elems.curr.classList.remove('d-none');
  window.elems.curr.innerText = node;

  for(let n of document.querySelectorAll(`[node]`))
    n.classList.remove('active');
  document.querySelector(`[node="${node}"]`).classList.add('active');

  if(in_progress) return;
  del_preview();
  
  let node_sel = document.querySelector(`[node="${node}"]`);
  if(!node_sel || node_sel.classList.contains('dull')) return;

  let children = JSON.parse(node_sel.getAttribute('children')) ?? [[]];

  let el;
  for(let i=1; i<children.length; i++){
    el = make_node({
      id: children[i][0],
      label: children[i][1],
      children: [],
    });
    el.classList.add("tmp");
    window.elems.preview.append(
      el
    );
  }

};

let del_preview = () => window.elems.preview.innerHTML = '';

let load = node => {
  if(window.pause) return alert("Paused!");
  
  if(in_progress) return;
  in_progress = true;

  remove_next(document.querySelector(`[node="${node}"]`).parentElement.nextElementSibling);

  $.ajax({
    url: `/node/${node}`,
    method: 'GET',
    success: r => {
      if(typeof r != "object")
        r = JSON.parse(r) ?? {};

      if(r.success && r.nodes){
        let shelve = document.createElement('div');
        
        for (let c of ['shelve', 'columns', 'align-stretch'])
          shelve.classList.add(c);
        shelve.setAttribute('shelve', r.target);
        
        shelve.append(make_plus(r.target));
        for(let node of r.nodes){        
          shelve.append(
            make_node(node)
          );
        }

        document.getElementById('master-wall').append(shelve);
      }
      in_progress = false;
    },
    error: () => {
      alert("Please Check Your Internet Connection!");
      in_progress = false;
    },
  });
};

let remove_next = el => {
  if(!el) return;
  if(el.nextElementSibling) remove_next(el.nextElementSibling);
  el.remove();
};

let make_plus = target => {
  let plus = document.createElement('div');
  plus.classList.add('node-plus');
  plus.style.order = 1;
  // plus.setAttribute("onclick", `add_node(${target})`);
  plus.innerText = "+";

  // plus.onclick = el => add_node(el.target.getAttribute('node'));
  plus.onclick = () => add_node(target);

  return plus;
}

let del = node => {
  if(window.pause) return alert("Paused!");

  in_progress = true;

  // Element Validation
  let elem = document.querySelector(`[node="${node}"]`);
  if(!elem) return;

  // A Unique Class
  let unique = +new Date;
  unique = 'u' + unique;

  // Mark That Unique Class
  elem.classList.add('dull');
  mark_all_targets(node, unique);

  // Delete Request
  $.ajax({
    url: `/node/${node}/del`,
    method: 'GET',
    success: r => {
      if(typeof r != "object")
        r = JSON.parse(r) ?? {};

      // If Success
      if(r.success){
        // Delete All Unique Targets
        let els = [];
        for(let el of document.getElementsByClassName(unique)){
          els.push(el);
        }
        for(let i=0; i<els.length; i++)
          if(els[i]){
            try {
              els[i].remove();
            } catch (error) {
              continue;              
            }
          }
      }
      in_progress = false;
    },
    error: () => {
      alert("Please Check Your Internet Connection!");
      in_progress = false;
    },
  });
};

let mark_all_targets = (node, unique) => {
  let n = document.querySelector(`[node="${node}"]`);
  if(!n) return;

  n.classList.add(unique);

  for(let shelve_nodes of document.querySelectorAll(`[shelve="${node}"] [node]`)){
    mark_all_targets(shelve_nodes.getAttribute('node'), unique);
  }
  let s = document.querySelector(`[shelve="${node}"]`);
  if(s) s.classList.add(unique);
};

let load_content = node => {
  if(window.pause) return alert("Paused!");
  window.loaded = true;

  window.elems.content_display.innerHTML = `
    <div class="white p30 text-center" style="border-top: 3px solid #fff;">
      <h1 class="heading-md m20">Loading...</h1>
    </div>
  `;
  window.elems.content_display.classList.remove('d-none');

  console.log(`Load Content: ${node} @pending-code`);
  let label = document.querySelector(`[node="${node}"]`).innerText.trim() ?? "<no-label>";
  
  $.ajax({
    url: `/node/${node}/content`,
    method: 'GET',
    success: r => {
      if(typeof r != "object")
        r = JSON.parse(r) ?? {};

      // If Success
      if(r.success){
        window.elems.content_display.innerHTML = `
          <div class="white p50 " style="border-top: 3px solid #fff;">
            <div class="between">
              <h1 id="edit-label" class="heading-md" contenteditable>${label}</h1>
              <div class="rows">
                <h1 class="heading-md cursor-pointer" onclick="update(${node});">SAVE</h1>
                <h1 class="heading-md cursor-pointer m20-l" onclick="close_content();">X</h1>
              </div>
            </div>
            <p  id="edit-content" class="para" contenteditable>${r.content}</p>
          </div>
        `;
        location.href = '#content-display';
      }
    },
    error: () => {
      alert("Please Check Your Internet Connection!");
      close_content();
    },
  });
};

let close_content = () => {
  window.loaded = false;
  window.elems.content_display.innerHTML = "";
  window.elems.content_display.classList.add('d-none');
};

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return false;
}

let toggle_pause = () => {
  window.pause = !window.pause;
  setCookie('curr', window.pause?1:0, 31);
};

window.pause = Boolean(Number(getCookie('curr')));

let under_update = false;
let update = node => {
  if(window.pause || under_update || !node) return;
  let
    label = document.getElementById('edit-label').innerText ?? '',
    content = document.getElementById('edit-content').innerText ?? ''
  ;

  if(!label) return;
  under_update = true;

  $.ajax({
    url: `/node/${node}`,
    method: 'POST',
    data: {
      label,
      content,
      _token: window.token,
    },
    success: r => {
      if(typeof r != "object")
        r = JSON.parse(r) ?? {};

      // If Success
      if(r.success){
        close_content();
      }
      under_update = false;
    },
    error: () => {
      alert("Please Check Your Internet Connection!");
      under_update = false;
    },
  });
};