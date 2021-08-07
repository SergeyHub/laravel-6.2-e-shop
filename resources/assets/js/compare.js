const Diff = require('diff');

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

window.runCompare = function()
{
    $(".compare").each(function (i) {
        let old_val = $(this).find(".old").text();
        let new_val = $(this).find(".new").text();
        let diff = Diff.diffWords(old_val, new_val);
        let colored_new = "";
        let colored_old = "";
        diff.forEach((part) => {
            // green for additions, red for deletions
            // grey for common parts
            let color = part.added ? '#6A6' :
                part.removed ? '#F66' : '#333';
            let underline = part.added ? 'underline' :
                part.removed ? 'underline' : 'none';
            if (!part.removed){
                colored_new += (`<span style="color:${color}; text-decoration: ${underline}">${escapeHtml(part.value)}</span>`);
            }
            if (!part.added){
                colored_old += (`<span style="color:${color}; text-decoration: ${underline}">${escapeHtml(part.value)}</span>`);
            }
        });
        $(this).find(".new").html(colored_new);
        $(this).find(".old").html(colored_old);
    });
}
