Package.describe({
  name: 'anback:bootstrap-validator',
  version: '0.9.0',
  summary: "Bootstrap-validator Packaged for Meteor, see  http://1000hz.github.io/bootstrap-validator",
  git: 'https://github.com/anback/bootstrap-validator.git',
  documentation: 'README.md'
});

Package.onUse(function(api) {
  api.addFiles('validator.min.js', 'client');
});