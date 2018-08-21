package cn.cinling.javacommon.util;


import cn.cinling.javacommon.exception.HttpUtilException;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.StatusLine;
import org.apache.http.client.config.RequestConfig;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;

import java.io.IOException;

public class HttpUtil {

    /**
     * 发送 get 请求
     * @param url 请求地址（支持https）
     * @return 返回内容
     */
    public static String Get(String url) throws HttpUtilException {
        CloseableHttpClient httpClient = HttpClients.createDefault();
        RequestConfig requestConfig = RequestConfig.custom()
                .setConnectTimeout(5000)   //设置连接超时时间
                .setConnectionRequestTimeout(5000) // 设置请求超时时间
                .setSocketTimeout(5000)
                .setRedirectsEnabled(true)//默认允许自动重定向
                .build();
        HttpGet httpGet2 = new HttpGet(url);
        httpGet2.setConfig(requestConfig);
        String responseString;
        try {
            HttpResponse httpResponse = httpClient.execute(httpGet2);
            int statusCode = httpResponse.getStatusLine().getStatusCode();

            if(statusCode == 200){
                responseString = EntityUtils.toString(httpResponse.getEntity());//获得返回的结果
            } else {
                httpClient.close();

                // 抛出状态码的异常
                HttpUtilException exception = new HttpUtilException("请求出错");
                exception.setResponseCode(statusCode);
                throw exception;
            }
        } catch (IOException e) {
            try {
                httpClient.close();
            } catch (IOException e1) {
                e1.printStackTrace();
            }

            // 抛出io异常
            HttpUtilException exception = new HttpUtilException(e.getMessage());
            exception.setStackTrace(e.getStackTrace());
            throw exception;
        } finally {
            try {
                httpClient.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }

        return responseString;
    }

    /**
     * @deprecated  发送 post 请求   未测试，不推荐使用
     * @param url 请求地址
     * @param params 请求参数
     * @return 返回数据
     */
    public static String Post(String url, String params) {

        CloseableHttpClient httpclient = HttpClients.createDefault();
        HttpPost httpPost = new HttpPost(url);// 创建httpPost
        httpPost.setHeader("Accept", "application/json");
        httpPost.setHeader("Content-Type", "application/json");
        String charSet = "UTF-8";
        StringEntity entity = new StringEntity(params, charSet);
        httpPost.setEntity(entity);
        CloseableHttpResponse response = null;

        try {

            response = httpclient.execute(httpPost);
            StatusLine status = response.getStatusLine();
            int state = status.getStatusCode();
            if (state == HttpStatus.SC_OK) {
                HttpEntity responseEntity = response.getEntity();
                String jsonString = EntityUtils.toString(responseEntity);
                System.out.println(jsonString);
                return jsonString;
            }
        } catch (IOException e) {
            e.printStackTrace();
        } finally {

            if (response != null) {
                try {
                    response.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            try {
                httpclient.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        return null;

    }
}
