
window.elems = {
  parent: document.getElementById('parent_node'),
  node: document.getElementById('new-node'),
  label: document.getElementById('new-node-label'),
  content: document.getElementById('new-node-content'),
  preview: document.getElementById('preview-shelve'),
  curr: document.getElementById('curr'),
  content_display: document.getElementById('content-display'),
};

document.body.addEventListener('keydown', e => {
  if(
    e.key == "Enter"
  ) document.getElementById('new-node').checked ?
    ((e.ctrlKey || e.shiftKey) ? add (true) : false) :
    (
      window.curr && !window.loaded ?
      load_content(window.curr) :
      false
    )
  ;

  else if(
    e.key == "Delete" &&
    !document.getElementById('new-node').checked &&
    window.curr
  ) del(window.curr);
  else if(
    e.key == "Escape"
  ){
    window.curr = 0;
    for(let n of document.querySelectorAll(`[node]`))
      n.classList.remove('active');
  }
  
  if(
    !document.getElementById('new-node').checked &&
    !window.loaded
  ){
    if(
      e.key.toUpperCase() == "P" &&
      window.p !== false
    ){
      if(window.p)
        location.href = '/panel/' + window.p;
      else
        location.href = '/panel';

    }
    else if(
      e.key.toUpperCase() == "G" &&
      window.curr
    ){
      location.href = '/panel/' + window.curr;
    }
  }

  else if(
    e.key == "CapsLock"
  ) toggle_pause();
});