# Open AI Spryker package
[![Build Status](https://github.com/spryker-shop/b2c-demo-shop/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/spryker-shop/b2c-demo-shop/actions?query=branch:master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spryker-shop/b2c-demo-shop/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/spryker-shop/b2c-demo-shop/?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg)](https://php.net/)

# Description
- OpenAI Client for spryker
- BO UI to manage prompts
- BO UI to generate prompts for:
    - product descriptions
    - seo title
    - seo keywords
    - seo description

# Screenshots
![1.png](1.png)
![2.png](2.png)
![3.png](3.png)
![4.png](4.png)
![5.png](5.png)
![6.png](6.png)

# Example usage
- use this snipped to upgrade backoffice inputs to openai inputs (also see `Zed/OpenAi/assets/Zed/js/modules/openai.js:4`)
 ```javascript
 attachOpenAiCompletionApiToToForm('textarea[name*="description"]', function(event, languageContext) {
  let nameInput = $('input[name*="'+languageContext+'][name"]');
  let skuInput = $('input[name*="'+languageContext+'][sku"]');
  return {title: nameInput.value, sku: skuInput.value};
 });
 ```

# HowTos Cli
 - docker/sdk up

ToDo:
 - prompt importer
 - cms page generate button
 - tests
 - refactor
