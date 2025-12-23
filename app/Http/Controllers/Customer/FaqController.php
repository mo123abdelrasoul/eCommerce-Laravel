<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'question' => 'How can I track my order?',
                'answer' => 'You can track your order by visiting the Order Tracking page and entering your order number or email address.'
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept major credit cards, PayPal, and bank transfers.'
            ],
            [
                'question' => 'What is your return policy?',
                'answer' => 'We offer a 30-day return policy for unused items in their original packaging. Please visit our Returns Policy page for more details.'
            ],
            [
                'question' => 'Do you ship internationally?',
                'answer' => 'Yes, we ship to most countries worldwide. Shipping costs and delivery times vary by location.'
            ],
            [
                'question' => 'How can I contact customer support?',
                'answer' => 'You can reach our customer support team via the Contact Us page or by emailing support@mstore24.com.'
            ],
        ];

        return view('customer.pages.faq', compact('faqs'));
    }
}
