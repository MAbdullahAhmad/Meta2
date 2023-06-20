

<div class="fg-1 no-wrap start align-stretch wall" id="master-wall">
  <div class="shelve o60" style="order: 1;" id="preview-shelve"></div>
  <div class="shelve columns align-stretch" shelve="0">
    <div class="node-plus" style="order: 1;" onclick="add_node(0);">+</div> {{-- Modal Trigger --}}
    @foreach($root_nodes as $node)
      <div class="node" children='[[]@foreach($node->children() as $ch),[{{ $ch->id }},"{{ $ch->label }}"]@endforeach]' node={{ $node->id }} onmouseenter="preview({{ $node->id }})" onclick="load({{ $node->id }})">{{ $node->label }}</div>
    @endforeach
  </div>
</div>

{{-- New Node Modal --}}
<input class="modal-btn" type="checkbox" id="new-node"/>
<div class="modal">
  <div class="modal-body p30-x p20" style="max-width: 650px; background: #000;">
    {{-- Header --}}
    <div class="between">
      <h1 class="heading-xs white">Add Node</h1>
      <a href="#" class="link" type="button" onclick="document.getElementById('new-node').checked = false;">
        <img src="{{ asset('icons/cancel.svg') }}" alt="x" class="icon img-white">
      </a>
    </div>
    {{-- Body --}}
    <div class="columns align-stretch">
      <input type="hidden" id="parent_node">
      <input type="text" id="new-node-label" class="input m10-y" placeholder="Label">
      <textarea id="new-node-content" class="input m10-y" placeholder="Content" style="resize: vertical; min-height: 400px;"></textarea>
    </div>
    {{-- Footer --}}
    <div class="p10-t rows">
      <button class="btn btn-primary p15-x align-center" id="add-btn" onclick="add();">
        <span class="secondary">
          Add
        </span>
        <img src="{{ asset("icons/plus.svg") }}" alt="+" class="icon m5-l img-secondary">
      </button>
    </div>
  </div>
</div>