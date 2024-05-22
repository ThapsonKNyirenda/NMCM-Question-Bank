<?php

return [
    'placeholders' => [
        'Ticket' => [
            'Ticket ID' => '{{ticket.id}}',
            'Title' => '{{ticket.title}}',
            'Description' => '{{ticket.description}}',
            'Team Name' => '{{ticket.team.name}}',
            'Ticket URL' => '{{ticket.url}}',
            'Due by Time' => '{{ticket.due_by_time}}',
            'Status' => '{{ticket.status}}',
            'Ticket Priority' => '{{ticket.priority}}',
            'Ticket Contact Name' => '{{ticket.requester.name}}'
        ],
        'Contact' => [
            'Contact Name' => '{{ contact.name }}'
        ]
    ]
];
