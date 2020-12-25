export default
{
    fields:
    [
        {
            name: 'category',
            type: 'text',
            label: 'Relief Good Category',
            placeholder: 'Your Category',
            className: 'form-control'
        },
        {
            name: 'name',
            type: 'text',
            label: 'Item Name',
            placeholder: 'Your Item Name',
            className: 'form-control'
        },
        {
            name: 'quantity',
            type: 'text',
            label: 'Quantity ',
            placeholder: '1',
            className: 'form-control'
        },
        {
            name: 'to',
            type: 'select',
            label: 'To',
            optionDefault: 'Donate to...',
            className: 'form-control'
        },

    ]
};
