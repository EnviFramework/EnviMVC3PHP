<?php
$finder = Symfony\Component\Finder\Finder::create()
    ->in(__DIR__.DIRECTORY_SEPARATOR.'libs/envi3')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$fixers = [

    // namespace setting
    'no_blank_lines_before_namespace',
    'line_after_namespace',
    'namespace_no_leading_whitespace',

    // use
    'ordered_use',
    // 'remove_leading_slash_use',
    'remove_lines_between_uses',

    // semicolon
    'duplicate_semicolon',
    'multiline_spaces_before_semicolon',
    'spaces_before_semicolon',

    // array syntax
    'long_array_syntax',
    'single_array_no_trailing_comma',
    'multiline_array_trailing_comma',

    'trim_array_spaces',
    'array_element_no_space_before_comma',
    'array_element_white_space_after_comma',

    // align
    'align_equals',
    'align_double_arrow',


    // print
    'print_to_echo',

    // single
    'single_quote',

    'whitespacy_lines',
    'unneeded_control_parentheses',
    'unary_operators_spaces',


    'operators_spaces',
    'ternary_spaces',
    'standardize_not_equal',

    // php doc setting
    'phpdoc_trim',
    'phpdoc_type_to_var',
    'phpdoc_types',
    'phpdoc_scalar',
    'phpdoc_params',
    'phpdoc_indent',
    'no_empty_lines_after_phpdocs',

    // use strict
    // 'strict',


];

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers($fixers)
    ->finder($finder)
    ->setUsingCache(true);
