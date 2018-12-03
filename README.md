# Installation
php -f bin/magento module:enable Alexsample_Shopper  
php -f bin/magento setup:upgrade  
php -f bin/magento cache:clean  
rm -rf pub/static/\*; rm -rf var/view_preprocessed/\*; php -f bin/magento setup:static-content:deploy
  
# Create token:
php bin/magento alexsample:shopper --create-token  
php bin/magento alexsample:shopper --get-token

# createNewShopper:
curl -X POST -H "Content-Type: application/json" -H "Accept: application/json" -d '{"shopper": {"email": "test@test.com", "name": "test", "last_name": "test", "phone": "1111111", "city": "test", "street": "test 0", "house_number": "1B"}}' "http://test.com/rest/all/V1/shopper/create/"

# updateShopper:
curl -X POST -H "Content-Type: application/json" -H "Accept: application/json" -d '{"shopper": {"email": "test@test.com", "name": "test1", "last_name": "test1", "phone": "2222222", "city": "test1", "street": "test 1", "house_number": "2B"}}' "http://test.com/rest/all/V1/shopper/update/"

# getShopperById:
curl -X GET -H "Accept: application/json" "http://test.com/rest/all/V1/shopper/1"

# createNewOrder:
curl -X POST -H "Content-Type: application/json" -H "Accept: application/json" -d '{"order": {"order_id": "testOrder2", "shopper_id": "1", "order_total": "128.00"}, "token": "hhu2cx7y0rm163asz2l8gyahpiqkvdh8"}' "http://test.com/rest/all/V1/order/create/"

# getOrders:
curl -X GET -H "Accept: application/json" "http://test.com/rest/all/V1/order/get_by_shopper/1"

# Admin panel:
SALES->Alexsample Shopper->Shopper  
SALES->Alexsample Shopper->Order
