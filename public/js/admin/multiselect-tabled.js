var Multiselect = function($node)
{
    let multiselect = this;

    $node.find(".btn-select").click(function () {
        $(this).find("input").attr("checked", !$(this).find("input").attr("checked"));
        multiselect.calc($(this).find("input").attr("name"));
    });

    $node.find("input[data-role='search']").keyup(function () {
        multiselect.find($(this).val());
    });

    $node.find("a[data-role='clear']").click(function () {
        $node.find("input[data-role='search']").val("");
        multiselect.find("");
    });

    $node.find("a[data-role='toggle']").click(function () {
        $(this).toggleClass("active");
        multiselect.toggle();
    });

    this.toggle_value = false;
    this.$node = $node;
};

Multiselect.prototype =
    {
        find:function(text)
        {
            let multiselect = this.$node;
            this.$node.find("tbody td.field_option").each(function (v) {
                if ($(this).text().toLowerCase().indexOf(text.toLowerCase()) >= 0)
                {
                    $(this).parent().removeClass("hide");
                }
                else
                {
                    $(this).parent().addClass("hide");
                }
            });
        },
        toggle:function()
        {
            this.toggle_value = !this.toggle_value;
            let multiselect = this.$node;
            if (this.toggle_value)
            {
                this.$node.find("tbody tr").each(function (v) {
                    if ($(this).find("input[checked]").length == 0)
                    {
                        $(this).addClass("hide");
                    }
                    else
                    {
                        $(this).removeClass("hide");
                    }

                });
            }
            else
            {
                this.$node.find("tbody tr").removeClass("hide");
            }

        },
        calc:function (name) {
            let count = this.$node.find("input[name='"+name+"'][checked]").length;
            this.$node.find("span[data-toggle='calc'][data-target='"+name+"']").text(count);
        }
    };