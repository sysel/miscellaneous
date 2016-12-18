#
# Cookbook Name:: apache_test
# Spec:: default
#
# Copyright (c) 2016 The Authors, All Rights Reserved.

require 'spec_helper'

at_exit { ChefSpec::Coverage.report! }

describe 'apache_test::default' do
  context 'When all attributes are default, on an unspecified platform' do
    let(:chef_run) do
      runner = ChefSpec::ServerRunner.new
      runner.converge(described_recipe)
    end

    it 'converges successfully' do
      expect { chef_run }.to_not raise_error
    end

    it 'installs apache2' do
      expect(chef_run).to install_package('httpd')
    end

    it 'enables ad starts apache service' do
      expect(chef_run).to enable_service('httpd')
      expect(chef_run).to start_service('httpd')
    end

    it 'creates template' do
      expect(chef_run).to create_template('/var/www/html/index.html').with(mode: '0644')
    end
  end
end
