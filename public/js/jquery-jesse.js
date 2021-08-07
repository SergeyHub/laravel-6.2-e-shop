(function($){
	var methods = {
		init: function(options) {
			var list = $(this),
				cells = [];

			var settings = $.extend({
				selector: 	 'li',
				dragClass: 	 '_isDragged',
				placeholder: '<li class="jq-jesse__placeholder"></li>'
			}, options);

			function calculatePositions(){
				list.children(settings.selector).each(function(key, item){
					var offset = $(item).offset();

					cells[key] = {
						x1: offset.left,
						y1: offset.top,
						x2: offset.left + $(item).outerWidth(),
						y2: offset.top + $(item).outerHeight(),
					};

					$(item).css({
						left: cells[key].x1 - list.offset().left,
						top: cells[key].y1 - list.offset().top
					});
				});
			}

			function findPosition(x, y) {
				var newPositon = null;
				$.each(cells, function(key, item) {
					if (x > item.x1 && x < item.x2 && y > item.y1 && y < item.y2){
						newPositon = key;
						return;
					}
				});
				return newPositon;
			}

			function insertItem(item, exclude, position) {
				if (position == 0) {
					item.prependTo(list);
				}else{
					item.insertAfter(list.children(settings.selector).not(item).not(exclude)[position - 1]);
				}
			}

			list.on('mousedown', settings.selector, function(e){
				calculatePositions();
				e.preventDefault();

				var draggedItem = $(this).addClass(settings.dragClass),
					placeholder = $(settings.placeholder);

				var offset = {
					top: e.pageY - draggedItem.offset().top + list.offset().top,
					left: e.pageX - draggedItem.offset().left + list.offset().left
				};

				var prevPosition = position = draggedItem.index();

				placeholder.insertBefore(draggedItem);

				$(document)
					.on('mousemove', function(e){
						e.preventDefault();

						draggedItem.css({
							top: e.pageY - offset.top,
							left: e.pageX - offset.left
						});

						var newPosition = findPosition(e.pageX, e.pageY);;

						if (newPosition != position && newPosition != null) {
							position = newPosition;
							insertItem(placeholder, draggedItem, position);

							if (typeof(settings.onChangePosition) == 'function')
								settings.onChangePosition(position, prevPosition, draggedItem);
						}
					})
					.on('mouseup', function(e){
						insertItem(draggedItem, placeholder, position);
						placeholder.remove();
						
						draggedItem.removeClass(settings.dragClass);

						$(this)
							.off('mousemove')
							.off('mouseup');

						if (typeof(settings.onStop) == 'function')
							settings.onStop(position, prevPosition, draggedItem);	
					});
			});
		}
	}

	$.fn.jesse = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
        else {
            $.error('Method '+method+' does not exist on jQuery.jesse');
        }
    };
})(jQuery);